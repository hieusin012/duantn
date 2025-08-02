<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $query = Voucher::query();

        if ($request->has('keyword') && $request->keyword) {
            $query->where('code', 'like', '%' . strtoupper($request->keyword) . '%');
        }

        $vouchers = $query->latest()->paginate(10);

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
        ], [
            'code.required' => 'Vui lòng nhập mã khuyến mãi.',
            'code.max' => 'Mã khuyến mãi tối đa 10 ký tự.',
            'code.unique' => 'Mã khuyến mãi đã tồn tại.',
            'discount.required' => 'Vui lòng nhập giá trị giảm.',
            'discount.numeric' => 'Giá trị giảm phải là số.',
            'discount.min' => 'Giá trị giảm không được âm.',
            'discount_type.required' => 'Vui lòng chọn loại giảm.',
            'discount_type.in' => 'Loại giảm không hợp lệ.',
            'quantity.required' => 'Vui lòng nhập số lượng mã.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn 0.',
            'max_price.numeric' => 'Giá giảm tối đa phải là số.',
            'max_price.min' => 'Giá giảm tối đa không được âm.',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
            'end_date.date' => 'Ngày kết thúc không hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            'is_active.required' => 'Vui lòng chọn trạng thái.',
            'is_active.boolean' => 'Trạng thái không hợp lệ.',
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
        ], [
            'discount.required' => 'Vui lòng nhập giá trị giảm.',
            'discount.numeric' => 'Giá trị giảm phải là số.',
            'discount.min' => 'Giá trị giảm không được âm.',
            'discount_type.required' => 'Vui lòng chọn loại giảm.',
            'discount_type.in' => 'Loại giảm không hợp lệ.',
            'quantity.required' => 'Vui lòng nhập số lượng mã.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn 0.',
            'max_price.numeric' => 'Giá giảm tối đa phải là số.',
            'max_price.min' => 'Giá giảm tối đa không được âm.',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
            'end_date.date' => 'Ngày kết thúc không hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            'used.integer' => 'Số lượt sử dụng phải là số nguyên.',
            'used.min' => 'Số lượt sử dụng không được âm.',
            'is_active.required' => 'Vui lòng chọn trạng thái.',
            'is_active.boolean' => 'Trạng thái không hợp lệ.',
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

        if ($voucher->used > 0) {
            return redirect()->route('admin.vouchers.index')->with('error', 'Không thể xóa khuyến mãi vì đang được sử dụng');
        }

        $voucher->delete();

        return redirect()->route('admin.vouchers.index')->with('success', 'Xóa voucher thành công.');
    }
}
