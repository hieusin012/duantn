<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ThongKeController extends Controller
{
    public function index()
    {
        return view('admin.thongke.index');
    }

    public function getData(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        $data = DB::table('products')
            ->select('categories.name as category_name', DB::raw('count(products.id) as total'))
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->when($month, function ($query) use ($month) {
                $query->whereMonth('products.created_at', $month);
            })
            ->when($year, function ($query) use ($year) {
                $query->whereYear('products.created_at', $year);
            })
            ->groupBy('categories.name')
            ->get();

        return response()->json($data);
    }
}

