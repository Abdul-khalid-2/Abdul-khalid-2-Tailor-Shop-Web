<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TailorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // First, ensure at least one branch exists
        $branch = DB::table('branches')->first();
        $branchId = $branch ? $branch->id : null;

        // You might want to create users first, or use existing ones
        // For now, we'll leave user_id as null or you can create users first

        $tailors = [
            [
                'name' => 'Muhammad Asif',
                'user_id' => null, // Will be linked when user is created
                'phone' => '+92 300 1234567',
                'cnic' => '35201-1234567-8',
                'address' => 'House #123, Street 5, Gulberg III, Lahore',
                'specializations' => json_encode(['Sherwani', 'Kurta Shalwar', 'Business Suit']),
                'employment_type' => 'permanent',
                'salary' => 45000.00,
                'commission_rate' => 5.00,
                'status' => 'active',
                'branch_id' => $branchId,
                'joining_date' => '2020-03-15',
                'notes' => 'Expert in traditional wear with 15 years experience. Speaks Urdu and Punjabi.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ali Raza',
                'user_id' => null,
                'phone' => '+92 321 2345678',
                'cnic' => '35202-2345678-9',
                'address' => 'Flat #201, Block B, Johar Town, Lahore',
                'specializations' => json_encode(['Wedding Gown', 'Evening Gown', 'Traditional Dress']),
                'employment_type' => 'permanent',
                'salary' => 42000.00,
                'commission_rate' => 4.50,
                'status' => 'active',
                'branch_id' => $branchId,
                'joining_date' => '2021-06-10',
                'notes' => 'Specializes in women\'s formal wear. Excellent embroidery work.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Kamran Ahmed',
                'user_id' => null,
                'phone' => '+92 333 3456789',
                'cnic' => '35301-3456789-0',
                'address' => 'Sector G-7/2, Islamabad',
                'specializations' => json_encode(['Business Suit', 'Blazer', 'Tuxedo', 'Formal Trousers']),
                'employment_type' => 'contract',
                'salary' => 38000.00,
                'commission_rate' => 6.00,
                'status' => 'active',
                'branch_id' => $branchId,
                'joining_date' => '2022-01-20',
                'notes' => 'Western wear specialist. Trained in Italy for 2 years.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Shahid Mehmood',
                'user_id' => null,
                'phone' => '+92 334 4567890',
                'cnic' => '42101-4567890-1',
                'address' => 'DHA Phase 6, Karachi',
                'specializations' => json_encode(['Kurta Shalwar', 'Pathani Suit', 'Peshawari Shalwar Kameez']),
                'employment_type' => 'freelance',
                'salary' => null,
                'commission_rate' => 15.00,
                'status' => 'active',
                'branch_id' => $branchId,
                'joining_date' => '2023-02-28',
                'notes' => 'Works on commission basis only. Fast worker, completes orders quickly.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Zahid Hussain',
                'user_id' => null,
                'phone' => '+92 335 5678901',
                'cnic' => '45501-5678901-2',
                'address' => 'University Road, Peshawar',
                'specializations' => json_encode(['Sherwani', 'Traditional Dress', 'Waistcoat']),
                'employment_type' => 'contract',
                'salary' => 35000.00,
                'commission_rate' => 5.50,
                'status' => 'on_leave',
                'branch_id' => $branchId,
                'joining_date' => '2021-11-15',
                'notes' => 'On medical leave until further notice. Expected return: 2 months.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Bilal Ahmed',
                'user_id' => null,
                'phone' => '+92 336 6789012',
                'cnic' => '41601-6789012-3',
                'address' => 'Saddar, Rawalpindi',
                'specializations' => json_encode(['Churidar Pajama', 'Summer Kurta', 'Punjabi Kurta']),
                'employment_type' => 'permanent',
                'salary' => 32000.00,
                'commission_rate' => 4.00,
                'status' => 'active',
                'branch_id' => $branchId,
                'joining_date' => '2023-05-10',
                'notes' => 'Junior tailor, still in training. Good at basic alterations.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Faisal Khan',
                'user_id' => null,
                'phone' => '+92 337 7890123',
                'cnic' => '43201-7890123-4',
                'address' => 'Cantt Area, Quetta',
                'specializations' => json_encode(['Sherwani', 'Kurta Shalwar', 'Waistcoat', 'Traditional Dress']),
                'employment_type' => 'contract',
                'salary' => 40000.00,
                'commission_rate' => 7.00,
                'status' => 'inactive',
                'branch_id' => $branchId,
                'joining_date' => '2022-08-05',
                'notes' => 'Left the job last month. Might return if offered better salary.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($tailors as $tailor) {
            // Check if phone already exists to avoid duplicates
            $exists = DB::table('tailors')->where('phone', $tailor['phone'])->exists();

            if (!$exists) {
                DB::table('tailors')->insert($tailor);
            }
        }
    }
}
