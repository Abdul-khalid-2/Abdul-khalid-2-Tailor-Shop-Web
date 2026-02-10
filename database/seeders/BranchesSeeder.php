<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branches = [
            [
                'name' => 'Main Store - Lahore',
                'code' => 'BR-LHR-001',
                'phone' => '+92 42 1234567',
                'email' => 'info@tailormaster.lahore.com',
                'address' => 'MM Alam Road, Gulberg, Lahore, Pakistan',
                'manager_name' => 'Ali Ahmed',
                'manager_phone' => '+92 300 1234567',
                'manager_email' => 'ali.ahmed@tailormaster.com',
                'opening_time' => '09:00:00',
                'closing_time' => '20:00:00',
                'working_days' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']),
                'is_active' => true,
                'opening_date' => '2020-01-15',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($branches as $branch) {
            // Check if branch code already exists
            $exists = DB::table('branches')->where('code', $branch['code'])->exists();

            if (!$exists) {
                DB::table('branches')->insert($branch);
            }
        }
    }
}
