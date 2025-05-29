<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::orderBy('created_at', 'desc')->paginate(10);
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
        ], [
            'name.required' => 'Trường tên size là bắt buộc',
            'name.unique' => 'Tên size đã tồn tại',
        ]);

        Size::create($request->only('name'));

        return redirect()->route('sizes.index')->with('success', 'Size created successfully.');
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
        ], [
            'name.required' => 'Trường tên size là bắt buộc',
            'name.unique' => 'Tên size đã tồn tại',
        ]);

        $size->update($request->only('name'));

        return redirect()->route('sizes.index')->with('success', 'Size updated successfully.');
    }

    public function destroy(Size $size)
    {
        $size->delete();
        return redirect()->route('sizes.index')->with('success', 'Size deleted successfully.');
    }
}
