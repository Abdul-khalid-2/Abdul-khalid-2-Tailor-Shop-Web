<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FabricsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fabrics = [
            [
                // Basic Info
                'name' => 'Pure Cotton Khaddar',
                'fabric_code' => 'FC-PCK-001',
                'type' => 'cotton',
                'color' => 'Beige',
                'pattern' => 'Plain',
                'gsm' => 180,
                'description' => 'Traditional handwoven cotton khaddar fabric, perfect for summer kurtas and shalwars. Breathable and comfortable for Pakistani climate.',

                // Stock & Pricing
                'stock_meter' => 150.500,
                'min_stock_meter' => 25.000,
                'purchase_rate' => 450.00,
                'selling_rate' => 680.00,

                // Supplier
                'supplier' => 'Khaddar Weavers Lahore',
                'supplier_reference' => 'KW-LHR-2024-01',
                'purchase_date' => '2024-01-15',
                'invoice_number' => 'INV-KW-78901',

                // Properties
                'width_inches' => 54,
                'shrinkage' => 3.50,
                'wash_care' => 'Hand wash cold, do not bleach, line dry in shade',
                'suitable_for' => json_encode(['Kurta Shalwar', 'Summer Kurta', 'Punjabi Kurta']),

                // Flags
                'is_premium' => false,
                'is_imported' => false,
                'is_eco_friendly' => true,

                // Extra
                'storage_location' => 'Rack A-1',
                'status' => 'active',
                'notes' => 'Traditional fabric, popular for summer wear. Needs to be pre-washed before stitching.',

                'branch_id' => 1, // Assuming branch_id 1 exists
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // Basic Info
                'name' => 'Pure Silk Banarasi',
                'fabric_code' => 'FS-PSB-002',
                'type' => 'silk',
                'color' => 'Maroon',
                'pattern' => 'Jacquard',
                'gsm' => 120,
                'description' => 'Luxurious pure silk Banarasi fabric with gold zari work. Ideal for wedding sherwanis and formal occasion wear.',

                // Stock & Pricing
                'stock_meter' => 75.250,
                'min_stock_meter' => 10.000,
                'purchase_rate' => 2800.00,
                'selling_rate' => 4200.00,

                // Supplier
                'supplier' => 'Banarasi Silk House Karachi',
                'supplier_reference' => 'BS-KHI-2024-02',
                'purchase_date' => '2024-02-10',
                'invoice_number' => 'INV-BS-12345',

                // Properties
                'width_inches' => 45,
                'shrinkage' => 1.20,
                'wash_care' => 'Dry clean only',
                'suitable_for' => json_encode(['Sherwani', 'Waistcoat', 'Formal Kurta']),

                // Flags
                'is_premium' => true,
                'is_imported' => false,
                'is_eco_friendly' => false,

                // Extra
                'storage_location' => 'Premium Section P-2',
                'status' => 'active',
                'notes' => 'High-end fabric for wedding collections. Handle with care to avoid damage to zari work.',

                'branch_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // Basic Info
                'name' => 'Italian Wool Blend',
                'fabric_code' => 'FW-IBL-003',
                'type' => 'wool',
                'color' => 'Navy Blue',
                'pattern' => 'Herringbone',
                'gsm' => 280,
                'description' => 'Premium Italian wool blend fabric with herringbone pattern. Perfect for business suits, blazers, and formal trousers.',

                // Stock & Pricing
                'stock_meter' => 95.750,
                'min_stock_meter' => 15.000,
                'purchase_rate' => 3200.00,
                'selling_rate' => 4800.00,

                // Supplier
                'supplier' => 'European Textiles Imports',
                'supplier_reference' => 'ETI-IMP-2024-03',
                'purchase_date' => '2024-03-05',
                'invoice_number' => 'INV-ETI-67890',

                // Properties
                'width_inches' => 58,
                'shrinkage' => 0.80,
                'wash_care' => 'Dry clean recommended',
                'suitable_for' => json_encode(['Business Suit', 'Blazer', 'Formal Trousers', 'Tuxedo']),

                // Flags
                'is_premium' => true,
                'is_imported' => true,
                'is_eco_friendly' => false,

                // Extra
                'storage_location' => 'Western Wear Section W-3',
                'status' => 'active',
                'notes' => 'Imported fabric for high-end tailoring. Limited stock, reorder when reaches minimum.',

                'branch_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        foreach ($fabrics as $fabric) {
            // Check if fabric code already exists to avoid duplicates
            $exists = DB::table('fabrics')->where('fabric_code', $fabric['fabric_code'])->exists();

            if (!$exists) {
                DB::table('fabrics')->insert($fabric);
            }
        }
    }
}
