<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('id', 'desc')->get();
        return view('admin.brands.index', compact('brands'));
    }
    public function create()
    {
        return view('admin.brands.create');
    }
    public function store(Request $request)
    {
    $request->validate([
    'name' => 'required|string|max:50|unique:brands,name',
    'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ], [
    'name.required' => 'Vui lòng nhập tên thương hiệu.',
    'name.unique' => 'Tên thương hiệu đã tồn tại.',
    'logo.required' => 'Vui lòng chọn ảnh đại diện.',
    'logo.image' => 'Tập tin phải là hình ảnh.',
    ]);

    $name = Str::lower(trim($request->name));

    $data = [
        'name' => $name,
        'logo' => $request->file('logo')->store('brands', 'public'),
    ];

    Brand::create($data);

    return redirect()->route('admin.brands.index')->with('success', 'Thêm thương hiệu thành công!');
    }
    //edit
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }
    //update
    public function update(Request $request, $id)
    {
    $request->validate([
        'name' => 'required|string|max:50|unique:brands,name,' . $id,
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $brand = Brand::findOrFail($id);

    $name = Str::lower(trim($request->name));

    $data = [
        'name' => $name,
    ];

    if ($request->hasFile('logo')) {
        $data['logo'] = $request->file('logo')->store('brands', 'public');
    }

    $brand->update($data);

    return redirect()->route('admin.brands.index')->with('success', 'Cập nhật thương hiệu thành công!');
    }
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Ẩn thương hiệu thành công!');
    }
    public function delete(){
        $deletedbrands = Brand::onlyTrashed()->get();
        return view('admin.brands.delete', compact('deletedbrands'));
    }
    public function restore($id)
    {
        $brand = Brand::withTrashed()->findOrFail($id);
        $brand->restore();
        return redirect()->route('admin.brands.index')->with('success', 'Khôi phục thương hiệu thành công!');
    }
    public function eliminate($id)
    {
        $brand = Brand::withTrashed()->findOrFail($id);
        $brand->forceDelete();
        return redirect()->route('admin.brands.index')->with('success', 'Xóa vĩnh viễn thương hiệu thành công!');
    }
    public function forceDeleteAll()
    {
        $deletedBrands = Brand::onlyTrashed()->get();
        foreach ($deletedBrands as $brand) {
            $brand->forceDelete();
        }
        return redirect()->route('admin.brands.delete')->with('success', 'Xóa vĩnh viễn tất cả thương hiệu thành công!');
    }
    
}