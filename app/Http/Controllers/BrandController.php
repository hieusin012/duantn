<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

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
            'name' => 'required|string|max:50',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'logo' => $request->file('logo')->store('brands', 'public'),
        ];
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('brands', 'public');
        }
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
            'name' => 'required|string|max:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $brand = Brand::findOrFail($id);
        $data = [
            'name' => $request->name,
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
        return redirect()->route('admin.brands.index')->with('success', 'Xóa thương hiệu thành công!');
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