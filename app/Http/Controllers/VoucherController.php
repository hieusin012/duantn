<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->paginate(10);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:vouchers',
            'discount' => 'required|numeric|min:0',
            'discount_type' => 'required|in:percent,fixed',
            'quantity' => 'required|integer|min:1',
            'max_price' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
        ]);

        Voucher::create([
            'code' => strtoupper($request->code),
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'quantity' => $request->quantity,
            'max_price' => $request->max_price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'used' => 0,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.vouchers.index')->with('success', 'Tạo voucher thành công.');
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'discount' => 'required|numeric|min:0',
            'discount_type' => 'required|in:percent,fixed',
            'quantity' => 'required|integer|min:1',
            'max_price' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'used' => 'nullable|integer|min:0',
            'is_active' => 'required|boolean',
        ]);

        $voucher->update([
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'quantity' => $request->quantity,
            'max_price' => $request->max_price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'used' => $request->used ?? 0,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.vouchers.index')->with('success', 'Cập nhật voucher thành công.');
    }

    public function show($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.vouchers.show', compact('voucher'));
    }

    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()->route('admin.vouchers.index')->with('success', 'Xóa voucher thành công.');
    }
}
