<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommodityCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Perabotan',
            'Elektronik',
            'Kendaraan',
            'Peralatan Sekolah',
            'Bangunan',
        ];

        foreach ($categories as $category) {
            DB::table('commodity_categories')->insert([
                'name' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
