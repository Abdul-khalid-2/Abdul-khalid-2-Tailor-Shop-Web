<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Branch;
use App\Models\User;
use App\Models\Order;
use App\Models\MeasurementTemplate;
use App\Models\DressType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with(['user', 'branch'])
            ->withCount(['orders as orders_count'])
            ->withSum('orders as total_spent', 'final_amount')
            ->addSelect([
                'last_order_date' => Order::select('order_date')
                    ->whereColumn('customer_id', 'customers.id')
                    ->latest()
                    ->limit(1)
            ]);

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%")
                    ->orWhere('occupation', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by branch
        if ($request->has('branch_id') && $request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        // Filter by customer type
        if ($request->has('customer_type') && $request->customer_type) {
            $query->where('customer_type', $request->customer_type);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            switch ($request->status) {
                case 'active':
                    $query->has('orders');
                    break;
                case 'new':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
                case 'repeat':
                    $query->has('orders', '>=', 2);
                    break;
                case 'vip':
                    $query->where('customer_type', 'vip');
                    break;
            }
        }

        $customers = $query->latest()->paginate(15);

        // Get stats - FIXED
        $stats = [
            'total' => Customer::count(),
            'active' => Customer::has('orders')->count(),
            'new_this_month' => Customer::whereMonth('created_at', now()->month)->count(),
            'avg_orders' => $this->calculateAvgOrders(),
        ];

        $branches = Branch::all();

        return view('dashboard.customers.index', compact('customers', 'stats', 'branches'));
    }

    /**
     * Calculate average orders per customer
     */
    private function calculateAvgOrders()
    {
        $totalCustomers = Customer::count();
        if ($totalCustomers === 0) return 0;

        $totalOrders = Customer::has('orders')->withCount('orders')->get()->sum('orders_count');
        return round($totalOrders / $totalCustomers, 1);
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        $dressTypes = DressType::where('is_active', true)->get();

        return view('dashboard.customers.create', compact('branches', 'dressTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone',
            'email' => 'nullable|email|unique:users,email',
            'address' => 'nullable|string',
            'branch_id' => 'required|exists:branches,id',
            'reference' => 'nullable|string|max:255',
            'customer_type' => 'nullable|in:regular,vip,corporate,walk_in',
            'discount_rate' => 'nullable|numeric|min:0|max:50',
            'occupation' => 'nullable|string|max:255',
            'anniversary_date' => 'nullable|date',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'preferred_communication' => 'nullable|array',
            'preferred_communication.*' => 'in:sms,email,whatsapp',
            'send_welcome_message' => 'nullable|boolean',
            'notes' => 'nullable|string',
            'measurement_templates' => 'nullable|array',
            'measurement_templates.*.dress_type_id' => 'nullable|exists:dress_types,id',
            'measurement_templates.*.template_name' => 'nullable|string|max:255',
            'measurement_templates.*.measurements' => 'nullable|array',
            'measurement_templates.*.is_default' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($validated, $request) {
            // Handle profile photo upload
            $profilePhotoPath = "";
            if ($request->hasFile('profile_photo')) {

                $profilePhotoPath = Storage::disk('website')->put(
                    'assets/images/customer_images',
                    $request->file('profile_photo')
                );
            }
            // Create user if email provided
            $user = null;
            if (!empty($validated['email'])) {
                $password = Str::random(8);
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'password' => bcrypt($password),
                    'role' => 'customer',
                    'branch_id' => $validated['branch_id'],
                    'status' => 'active',
                ]);
            }

            // Create customer
            $customer = Customer::create([
                'user_id' => $user ? $user->id : null,
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'reference' => $validated['reference'],
                'customer_type' => $validated['customer_type'] ?? 'regular',
                'discount_rate' => $validated['discount_rate'] ?? 0,
                'occupation' => $validated['occupation'],
                'anniversary_date' => $validated['anniversary_date'],
                'profile_photo' => $profilePhotoPath,
                'preferred_communication' => $validated['preferred_communication'] ?? [],
                'send_welcome_message' => $validated['send_welcome_message'] ?? false,
                'notes' => $validated['notes'],
                'branch_id' => $validated['branch_id'],
                'created_by' => auth()->id(),
            ]);

            // Create measurement templates if provided
            if (!empty($validated['measurement_templates'])) {
                foreach ($validated['measurement_templates'] as $templateData) {
                    if (!empty($templateData['dress_type_id']) && !empty($templateData['template_name'])) {
                        MeasurementTemplate::create([
                            'customer_id' => $customer->id,
                            'dress_type_id' => $templateData['dress_type_id'],
                            'template_name' => $templateData['template_name'],
                            'measurements' => $templateData['measurements'] ?? [],
                            'notes' => $templateData['notes'] ?? null,
                            'is_default' => $templateData['is_default'] ?? false,
                            'created_by' => auth()->id(),
                        ]);
                    }
                }
            }

            // Send welcome message if requested
            if ($customer->send_welcome_message) {
                $this->sendWelcomeMessage($customer);
            }
        });

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        $customer->load([
            'user',
            'branch',
            'orders' => function ($q) {
                $q->latest()->with('status', 'paymentStatus');
            },
            'orders.items',
            'orders.payments',
            'measurementTemplates.dressType'
        ]);

        $stats = [
            'total_orders' => $customer->orders_count ?? $customer->orders()->count(),
            'total_spent' => $customer->total_spent ?? $customer->orders()->sum('final_amount'),
            'avg_order_value' => $customer->orders()->count() > 0
                ? round($customer->orders()->sum('final_amount') / $customer->orders()->count(), 2)
                : 0,
            'last_order' => $customer->orders()->latest()->first(),
            'pending_orders' => $customer->orders()->whereHas('status', function ($q) {
                $q->where('is_completed', false)->where('is_cancelled', false);
            })->count(),
        ];

        return view('dashboard.customers.show', compact('customer', 'stats'));
    }

    public function edit(Customer $customer)
    {
        $branches = Branch::where('is_active', true)->get();
        $dressTypes = DressType::where('is_active', true)->get();

        return view('dashboard.customers.edit', compact('customer', 'branches', 'dressTypes'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone,' . $customer->id,
            'email' => 'nullable|email|unique:users,email,' . ($customer->user_id ?: 'NULL'),
            'address' => 'nullable|string',
            'branch_id' => 'required|exists:branches,id',
            'reference' => 'nullable|string|max:255',
            'customer_type' => 'nullable|in:regular,vip,corporate,walk_in',
            'discount_rate' => 'nullable|numeric|min:0|max:50',
            'occupation' => 'nullable|string|max:255',
            'anniversary_date' => 'nullable|date',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'preferred_communication' => 'nullable|array',
            'preferred_communication.*' => 'in:sms,email,whatsapp',
            'send_welcome_message' => 'nullable|boolean',
            'notes' => 'nullable|string',
            'measurement_templates' => 'nullable|array',
            'measurement_templates.*.id' => 'nullable|exists:measurement_templates,id',
            'measurement_templates.*.dress_type_id' => 'nullable|exists:dress_types,id',
            'measurement_templates.*.template_name' => 'nullable|string|max:255',
            'measurement_templates.*.measurements' => 'nullable|array',
            'measurement_templates.*.is_default' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($validated, $request, $customer) {
            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                // Delete old photo if exists
                if ($customer->profile_photo) {
                    Storage::disk('public')->delete($customer->profile_photo);
                }
                $profilePhotoPath = $request->file('profile_photo')->store('customers/profile-photos', 'public');
                $validated['profile_photo'] = $profilePhotoPath;
            }

            // Update customer
            $customer->update([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'reference' => $validated['reference'],
                'customer_type' => $validated['customer_type'] ?? 'regular',
                'discount_rate' => $validated['discount_rate'] ?? 0,
                'occupation' => $validated['occupation'],
                'anniversary_date' => $validated['anniversary_date'],
                'preferred_communication' => $validated['preferred_communication'] ?? [],
                'send_welcome_message' => $validated['send_welcome_message'] ?? false,
                'notes' => $validated['notes'],
                'branch_id' => $validated['branch_id'],
                'updated_by' => auth()->id(),
                ...(isset($validated['profile_photo']) ? ['profile_photo' => $validated['profile_photo']] : [])
            ]);

            // Update or create user
            if (!empty($validated['email'])) {
                if ($customer->user) {
                    $customer->user->update([
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'phone' => $validated['phone'],
                        'branch_id' => $validated['branch_id'],
                    ]);
                } else {
                    $password = Str::random(8);
                    $user = User::create([
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'phone' => $validated['phone'],
                        'password' => bcrypt($password),
                        'role' => 'customer',
                        'branch_id' => $validated['branch_id'],
                        'status' => 'active',
                    ]);
                    $customer->update(['user_id' => $user->id]);
                }
            } elseif ($customer->user && empty($validated['email'])) {
                // Remove user if email is removed
                $customer->user->delete();
                $customer->update(['user_id' => null]);
            }

            // Update measurement templates
            if (!empty($validated['measurement_templates'])) {
                $existingTemplateIds = [];

                foreach ($validated['measurement_templates'] as $templateData) {
                    if (isset($templateData['id'])) {
                        // Update existing template
                        $template = MeasurementTemplate::find($templateData['id']);
                        if ($template && $template->customer_id == $customer->id) {
                            $template->update([
                                'dress_type_id' => $templateData['dress_type_id'],
                                'template_name' => $templateData['template_name'],
                                'measurements' => $templateData['measurements'] ?? [],
                                'notes' => $templateData['notes'] ?? null,
                                'is_default' => $templateData['is_default'] ?? false,
                                'updated_by' => auth()->id(),
                            ]);
                            $existingTemplateIds[] = $template->id;
                        }
                    } elseif (!empty($templateData['dress_type_id']) && !empty($templateData['template_name'])) {
                        // Create new template
                        $template = MeasurementTemplate::create([
                            'customer_id' => $customer->id,
                            'dress_type_id' => $templateData['dress_type_id'],
                            'template_name' => $templateData['template_name'],
                            'measurements' => $templateData['measurements'] ?? [],
                            'notes' => $templateData['notes'] ?? null,
                            'is_default' => $templateData['is_default'] ?? false,
                            'created_by' => auth()->id(),
                        ]);
                        $existingTemplateIds[] = $template->id;
                    }
                }

                // Delete templates not in the current list
                MeasurementTemplate::where('customer_id', $customer->id)
                    ->whereNotIn('id', $existingTemplateIds)
                    ->delete();
            }
        });

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        // Check if customer has orders
        if ($customer->orders()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete customer with existing orders.');
        }

        DB::transaction(function () use ($customer) {
            // Delete profile photo if exists
            if ($customer->profile_photo) {
                Storage::disk('public')->delete($customer->profile_photo);
            }

            // Delete measurement templates
            $customer->measurementTemplates()->delete();

            // Delete user if exists
            if ($customer->user) {
                $customer->user->delete();
            }

            // Delete customer
            $customer->delete();
        });

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }

    private function sendWelcomeMessage(Customer $customer)
    {
        // In real app: Implement SMS/Email sending logic
        // For now, just log it
        \Log::info('Welcome message sent to customer: ' . $customer->id);
    }
}
