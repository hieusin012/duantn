<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::orderBy('id', 'desc')->get();
        return view('admin.list_colors.index', compact('colors'));
    }

    public function create()
    {
        return view('admin.list_colors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'color_code' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6})$/'],
        ], [
            'color_code.regex' => 'Mã màu phải đúng định dạng HEX, ví dụ: #FF0000',
        ]);

        $data = [
            'name' => $request->name,
            'color_code' => strtoupper($request->color_code), // chuẩn hóa viết hoa
        ];

        Color::create($data);

        return redirect()->route('admin.colors.index')->with('success', 'Thêm màu thành công!');
    }

    public function edit($id)
    {
        $colors = Color::findOrFail($id);
        return view('admin.list_colors.edit', compact('colors'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'color_code' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6})$/'],
        ], [
            'color_code.regex' => 'Mã màu phải đúng định dạng HEX, ví dụ: #FF0000',
        ]);

        $color = Color::findOrFail($id);
        $color->update([
            'name' => $request->name,
            'color_code' => strtoupper($request->color_code),
        ]);

        return redirect()->route('admin.colors.index')->with('success', 'Cập nhật màu thành công!');
    }

    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();
        return redirect()->route('admin.colors.index')->with('success', 'Xóa màu thành công!');
    }

    public function delete()
    {
        $deletedColors = Color::onlyTrashed()->get();
        return view('admin.list_colors.delete', compact('deletedColors'));
    }

    public function eliminate($id)
    {
        $color = Color::withTrashed()->findOrFail($id);
        $color->forceDelete();
        return redirect()->route('admin.colors.delete')->with('success', 'Xóa màu vĩnh viễn thành công!');
    }

    public function forceDeleteAll()
    { 
        $deletedColors = Color::onlyTrashed()->get();
        foreach ($deletedColors as $color) {
            $color->forceDelete();
        }
        return redirect()->route('admin.colors.delete')->with('success', 'Xóa vĩnh viễn tất cả màu thành công!');
    }

    public function restore($id)
    {
        $color = Color::withTrashed()->findOrFail($id);
        $color->restore();
        return redirect()->route('admin.colors.index')->with('success', 'Khôi phục màu thành công!');
    }
}