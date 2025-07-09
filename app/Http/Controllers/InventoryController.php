<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $variants = ProductVariant::with(['product', 'color', 'size'])
            ->orderBy('quantity', 'asc')
            ->get();

        $lowStockThreshold = 10;

        return view('admin.inventory.index', [
            'variants' => $variants,
            'lowStockThreshold' => $lowStockThreshold
        ]);
    }
}
