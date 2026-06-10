<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Tailor;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        $branchId  = Branch::value('id');
        $createdBy = User::where('email', 'admin@example.com')->value('id');
        $pendingId = OrderStatus::where('name', 'Pending')->value('id') ?? 1;

        /* ---------------------------------------------------------------
         | Customers
         * ------------------------------------------------------------- */
        $ahmed = Customer::firstOrCreate(
            ['phone' => '+92 300 1112233'],
            ['name' => 'Ahmed Raza', 'address' => 'Model Town, Lahore', 'branch_id' => $branchId, 'created_by' => $createdBy]
        );

        $usman = Customer::firstOrCreate(
            ['phone' => '+92 321 4445566'],
            ['name' => 'Usman Tariq', 'address' => 'Bahria Town, Rawalpindi', 'branch_id' => $branchId, 'created_by' => $createdBy]
        );

        $hamza = Customer::firstOrCreate(
            ['phone' => '+92 333 7778899'],
            ['name' => 'Hamza Sheikh', 'address' => 'Clifton, Karachi', 'branch_id' => $branchId, 'created_by' => $createdBy]
        );

        /* ---------------------------------------------------------------
         | Tailors
         * ------------------------------------------------------------- */
        $tailorOne = Tailor::firstOrCreate(
            ['phone' => '+92 301 2223344'],
            ['name' => 'Naeem Tailor', 'cnic' => '35202-1112223-4', 'specialty' => 'sherwani', 'status' => 'active', 'joining_date' => '2019-04-01', 'branch_id' => $branchId]
        );

        $tailorTwo = Tailor::firstOrCreate(
            ['phone' => '+92 302 5556677'],
            ['name' => 'Saleem Master', 'cnic' => '42101-3334445-6', 'specialty' => 'shalwar_kameez', 'status' => 'active', 'joining_date' => '2021-09-12', 'branch_id' => $branchId]
        );

        /* ---------------------------------------------------------------
         | Orders (with suits + measurements)
         * ------------------------------------------------------------- */
        $orders = [
            [
                'customer'    => $ahmed,
                'tailor'      => $tailorOne,
                'label'       => 'For Self',
                'advance'     => 5000,
                'tailor_fee'  => 3000,
                'suits'       => [
                    ['color' => 'Green', 'quantity' => 1, 'stitching_charge' => 2500, 'button_charge' => 200, 'other_charge' => 0],
                    ['color' => 'Navy Blue', 'quantity' => 1, 'stitching_charge' => 2500, 'button_charge' => 200, 'other_charge' => 150, 'other_charge_note' => 'Lining'],
                    ['color' => 'Maroon', 'quantity' => 1, 'stitching_charge' => 2800, 'button_charge' => 250, 'other_charge' => 0],
                ],
                'measurement' => ['length' => 42.5, 'shoulder' => 18.0, 'chest' => 40.0, 'waist' => 36.0, 'sleeve' => 24.5, 'collar' => 16.0],
            ],
            [
                'customer'    => $usman,
                'tailor'      => $tailorTwo,
                'label'       => 'For Self',
                'advance'     => 2000,
                'tailor_fee'  => 1800,
                'suits'       => [
                    ['color' => 'White', 'quantity' => 2, 'stitching_charge' => 1800, 'button_charge' => 150, 'other_charge' => 0],
                ],
                'measurement' => ['length' => 44.0, 'shoulder' => 18.5, 'chest' => 42.0, 'waist' => 38.0, 'trouser_length' => 40.0, 'trouser_waist' => 34.0],
            ],
            [
                'customer'    => $hamza,
                'tailor'      => $tailorOne,
                'label'       => 'For Brother',
                'advance'     => 0,
                'tailor_fee'  => 2200,
                'suits'       => [
                    ['color' => 'Black', 'quantity' => 1, 'stitching_charge' => 3000, 'button_charge' => 300, 'other_charge' => 500, 'other_charge_note' => 'Embroidery'],
                    ['color' => 'Grey', 'quantity' => 1, 'stitching_charge' => 2600, 'button_charge' => 200, 'other_charge' => 0],
                ],
                'measurement' => ['length' => 41.0, 'shoulder' => 17.5, 'chest' => 38.0, 'waist' => 34.0, 'sleeve' => 23.5],
            ],
        ];

        foreach ($orders as $data) {
            $order = Order::firstOrCreate(
                ['customer_id' => $data['customer']->id, 'order_label' => $data['label']],
                [
                    'tailor_id'        => $data['tailor']->id,
                    'branch_id'        => $branchId,
                    'status_id'        => $pendingId,
                    'order_date'       => today()->subDays(3),
                    'delivery_date'    => today()->addDays(7),
                    'advance_paid'     => $data['advance'],
                    'tailor_fee_total' => $data['tailor_fee'],
                    'created_by'       => $createdBy,
                ]
            );

            foreach ($data['suits'] as $i => $suit) {
                $order->suits()->firstOrCreate(
                    ['color' => $suit['color']],
                    array_merge($suit, ['sort_order' => $i])
                );
            }

            $order->measurement()->firstOrCreate(
                ['order_id' => $order->id],
                $data['measurement']
            );

            $order->recalculate();
        }

        // Refresh cached tailor stats now that orders exist
        $tailorOne->syncStats();
        $tailorTwo->syncStats();
    }
}
