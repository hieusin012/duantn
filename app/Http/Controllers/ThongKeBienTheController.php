<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThongKeBienTheController extends Controller
{
    public function index()
    {
        return view('admin.thongke_bienthe.index');
    }

    public function getData(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $data = DB::table('product_variants')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('sizes', 'product_variants.size_id', '=', 'sizes.id')
            ->join('colors', 'product_variants.color_id', '=', 'colors.id')
            ->select(
                'products.name as product_name',
                'categories.name as category_name',
                'sizes.name as size_name',
                'colors.name as color_name',
                DB::raw('COUNT(product_variants.id) as total_variants')
            )
            ->when($fromDate, function ($query) use ($fromDate) {
                $query->whereDate('product_variants.created_at', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                $query->whereDate('product_variants.created_at', '<=', $toDate);
            })
            ->whereNull('product_variants.deleted_at')
            ->groupBy('products.name', 'categories.name', 'sizes.name', 'colors.name')
            ->orderBy('products.name')
            ->get();

        return response()->json($data);
    }
}
