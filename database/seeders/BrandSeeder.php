<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        // Xoá sạch dữ liệu (an toàn với foreign key)
        DB::table('brands')->delete();
        DB::statement('ALTER TABLE brands AUTO_INCREMENT = 1');

        DB::table('brands')->insert([
            [
                'id' => 1,
                'name' => 'Lịm Donuts',
                'logo' => 'logo-lim-donuts.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Sweet&Soft',
                'logo' => 'logo-sweet-soft.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
