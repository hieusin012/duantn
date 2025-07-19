<?php

// namespace App\Http\Controllers\Client;

// use App\Http\Controllers\Controller;
// use App\Models\Product;
// use Carbon\Carbon;

// class HotDealController extends Controller
// {
//     public function index()
//     {
//         $now = Carbon::now();

//         $hotDeals = Product::where('is_hot_deal', true)
//             ->whereNotNull('discount_percent')
//             ->where('deal_end_at', '>', $now)
//             ->get();

//         // Debug tạm thời
//         // if ($hotDeals->isEmpty()) {
//         //     dd('Không có hot deal nào', $hotDeals);
//         // }

//         return view('clients.hot_deals.index', compact('hotDeals'));
//     }

// }
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;

class HotDealController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        $hotDeals = Product::with('variants') // Tối ưu hiệu suất
            ->where('is_hot_deal', true)
            ->whereNotNull('discount_percent')
            ->where('deal_end_at', '>', $now)
            ->orderBy('deal_end_at', 'asc')
            ->get();

        return view('clients.hot_deals.index', compact('hotDeals'));
    }
}


