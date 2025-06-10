<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product; // Giả sử model là Product
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'code' => 'SP0001',
                'name' => 'Bánh Donut Socola',
                'slug' => Str::slug('Bánh Donut Socola'),
                'image' => 'donut-socola.jpg',
                'price' => 25000,
                'description' => 'Donut mềm mịn phủ socola đậm đà',
                'status' => 1,
                'is_active' => 1,
                'views' => 10,
                'category_id' => 1,
                'brand_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'code' => 'SP0002',
                'name' => 'Bánh Donut Dâu',
                'slug' => Str::slug('Bánh Donut Dâu'),
                'image' => 'donut-dau.jpg',
                'price' => 24000,
                'description' => 'Donut phủ mứt dâu tây thơm ngọt',
                'status' => 1,
                'is_active' => 1,
                'views' => 15,
                'category_id' => 1,
                'brand_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'code' => 'SP0003',
                'name' => 'Combo Donut 5 cái',
                'slug' => Str::slug('Combo Donut 5 cái'),
                'image' => 'combo-5-donut.jpg',
                'price' => 100000,
                'description' => 'Combo 5 bánh donut với nhiều vị khác nhau',
                'status' => 1,
                'is_active' => 1,
                'views' => 25,
                'category_id' => 2,
                'brand_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
