<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prize;

class PrizeSeeder extends Seeder
{
    public function run(): void
    {
        $prizes = [
            ['name' => 'Kem mát lạnh',     'weight' => 10, 'color' => '#FFEB3B'],
            ['name' => 'Chuyến du lịch',   'weight' => 1,  'color' => '#03A9F4'],
            ['name' => 'Thẻ điện thoại',   'weight' => 5,  'color' => '#8BC34A'],
            ['name' => 'Mũ bucket hè',     'weight' => 3,  'color' => '#FF9800'],
            ['name' => 'Voucher 100K',     'weight' => 4,  'color' => '#E91E63'],
            ['name' => 'Chúc may mắn lần sau', 'weight' => 20, 'color' => '#BDBDBD'],
        ];

        foreach ($prizes as $prize) {
            Prize::create($prize);
        }
    }
}
