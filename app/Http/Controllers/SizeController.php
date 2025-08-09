<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index(Request $request)
    {
        $query = Size::query();

        if ($request->has('keyword') && $request->keyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $sizes = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.sizes.index', compact('sizes'));
    }


    public function create()
    {
        return view('admin.sizes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sizes,name',
            'value' => 'required|numeric|min:1',
        ], [
            'name.required' => 'Trường tên size là bắt buộc',
            'name.unique' => 'Tên kích thước đã tồn tại, vui lòng chọn tên khác',
            'value.required' => 'Giá trị kích thước là bắt buộc',
            'value.numeric' => 'Giá trị phải là số',
            'value.min' => 'Giá trị kích thước không hợp lệ, vui lòng nhập số dương',
        ]);

        Size::create($request->only('name', 'value'));

        return redirect()->route('admin.sizes.index')->with('success', 'Kích cỡ được tạo thành công.');
    }

    public function show(Size $size)
    {
        return view('admin.sizes.show', compact('size'));
    }

    public function edit(Size $size)
    {
        return view('admin.sizes.edit', compact('size'));
    }

    public function update(Request $request, Size $size)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sizes,name,' . $size->id,
            'value' => 'required|numeric|min:1',
        ], [
            'name.required' => 'Trường tên size là bắt buộc',
            'name.unique' => 'Tên kích thước đã tồn tại, vui lòng chọn tên khác',
            'value.required' => 'Giá trị kích thước là bắt buộc',
            'value.numeric' => 'Giá trị phải là số',
            'value.min' => 'Giá trị kích thước không hợp lệ, vui lòng nhập số dương',
        ]);

        $size->update($request->only('name', 'value'));

        return redirect()->route('admin.sizes.index')->with('success', 'Đã cập nhật kích cỡ thành công.');
    }

    public function destroy(Size $size)
    {
        // if ($size->productVariants()->exists()) {
        //     return redirect()->route('admin.sizes.index')
        //         ->with('error', 'Không thể xóa kích thước đang được sử dụng');
        // }
        $size->delete();
        return redirect()->route('admin.sizes.index')->with('success', 'Đã xóa kích cỡ thành công.');
    }
    public function delete()
    {
        $deletedSizes = Size::onlyTrashed()->get();
        return view('admin.sizes.delete', compact('deletedSizes'));
    }

    public function restore($id)
    {
        $size = Size::withTrashed()->findOrFail($id);
        $size->restore();
        return redirect()->route('admin.sizes.index')->with('success', 'Khôi phục size thành công!');
    }

    public function eliminate($id)
    {
        $size = Size::withTrashed()->findOrFail($id);
        $size->forceDelete();
        return redirect()->route('admin.sizes.delete')->with('success', 'Xóa vĩnh viễn thành công!');
    }

    public function forceDeleteAll()
    {
        $sizes = Size::onlyTrashed()->get();
        foreach ($sizes as $size) {
            $size->forceDelete();
        }
        return redirect()->route('admin.sizes.delete')->with('success', 'Xóa vĩnh viễn tất cả size thành công!');
    }
}
