<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DressTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dressTypes = [
            // Pakistani Men's Traditional Wear
            [
                'name' => 'Sherwani',
                'description' => 'Traditional Pakistani wedding attire for grooms, often heavily embroidered with gold or silver thread work.',
                'base_price' => 300.00,
                'estimated_days' => 18,
                'is_active' => true,
            ],
            [
                'name' => 'Kurta Shalwar',
                'description' => 'Traditional everyday wear consisting of a long tunic (kurta) and loose trousers (shalwar).',
                'base_price' => 320.00,
                'estimated_days' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Peshawari Shalwar Kameez',
                'description' => 'Traditional wear from Khyber Pakhtunkhwa with loose, pleated shalwar and simple kameez.',
                'base_price' => 300.00,
                'estimated_days' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Sindhi Ajrak Kurta',
                'description' => 'Traditional Sindhi attire featuring Ajrak print kurtas, often worn with a Sindhi topi (cap).',
                'base_price' => 350.00,
                'estimated_days' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Waistcoat (Nehru Jacket)',
                'description' => 'Formal waistcoat or jacket worn over kurta for formal occasions and weddings.',
                'base_price' => 300.00,
                'estimated_days' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Churidar Pajama',
                'description' => 'Fitted trousers (churidar) worn with a long kurta, creating a sleek silhouette.',
                'base_price' => 340.00,
                'estimated_days' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Pathani Suit',
                'description' => 'Traditional Afghan-inspired attire popular in Pakistan, featuring a long kameez and loose shalwar.',
                'base_price' => 330.00,
                'estimated_days' => 5,
                'is_active' => true,
            ],

            [
                'name' => 'Punjabi Kurta',
                'description' => 'Traditional Punjabi style kurta with distinctive cuts and patterns.',
                'base_price' => 325.00,
                'estimated_days' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($dressTypes as $dressType) {
            // Generate slug from name
            $slug = Str::slug($dressType['name']);

            // Check if record exists to avoid duplicates
            $exists = DB::table('dress_types')->where('slug', $slug)->exists();

            if (!$exists) {
                DB::table('dress_types')->insert([
                    'name' => $dressType['name'],
                    'slug' => $slug,
                    'description' => $dressType['description'],
                    'base_price' => $dressType['base_price'],
                    'estimated_days' => $dressType['estimated_days'],
                    'is_active' => $dressType['is_active'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
