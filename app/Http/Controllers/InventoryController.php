<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        // $variants = ProductVariant::with(['product', 'color', 'size'])
        //     ->orderBy('quantity', 'asc')
        //     ->get();

        $variants = ProductVariant::with([
            'product',
            'color',
            'size',
            'orderDetails.order' => function ($query) {
                $query->whereIn('status', ['delivered', 'completed']);
            }
        ])->orderBy('quantity', 'asc')->get();

        $lowStockThreshold = 10;

        return view('admin.inventory.index', [
            'variants' => $variants,
            'lowStockThreshold' => $lowStockThreshold
        ]);
    }
}
