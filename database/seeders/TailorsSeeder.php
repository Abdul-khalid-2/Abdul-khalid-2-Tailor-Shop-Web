<?php

namespace Database\Seeders;

use App\Models\Tailor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TailorsSeeder extends Seeder
{
    public function run(): void
    {
        $branchId = DB::table('branches')->value('id');

        $tailors = [
            [
                'name'         => 'Muhammad Asif',
                'phone'        => '+92 300 1234567',
                'cnic'         => '35201-1234567-8',
                'address'      => 'House #123, Street 5, Gulberg III, Lahore',
                'joining_date' => '2020-03-15',
                'specialty'    => 'sherwani',
                'status'       => 'active',
                'notes'        => 'Expert in traditional wear with 15 years experience.',
            ],
            [
                'name'         => 'Kamran Ahmed',
                'phone'        => '+92 333 3456789',
                'cnic'         => '35301-3456789-0',
                'address'      => 'Sector G-7/2, Islamabad',
                'joining_date' => '2022-01-20',
                'specialty'    => 'all',
                'status'       => 'active',
                'notes'        => 'Western and traditional wear specialist.',
            ],
            [
                'name'         => 'Zahid Hussain',
                'phone'        => '+92 335 5678901',
                'cnic'         => '45501-5678901-2',
                'address'      => 'University Road, Peshawar',
                'joining_date' => '2021-11-15',
                'specialty'    => 'shalwar_kameez',
                'status'       => 'on_leave',
                'notes'        => 'On medical leave. Expected return in 2 months.',
            ],
        ];

        foreach ($tailors as $data) {
            Tailor::firstOrCreate(
                ['phone' => $data['phone']],
                array_merge($data, ['branch_id' => $branchId])
            );
        }
    }
}
