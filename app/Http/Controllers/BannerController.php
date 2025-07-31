<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $query = Banner::query();

        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        $banners = $query->latest()->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }


    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255|unique:banners,title',
            'link' => 'nullable|url',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'required|in:0,1',
            'location' => 'required|in:0,1',
        ],[
            'title.required' => 'Vui lòng nhập tên banner.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'title.unique' => 'Tiêu đề này đã tồn tại. Vui lòng chọn tên khác.',
            'link.url' => 'Liên kết không đúng định dạng URL.',
            'image.required' => 'Vui lòng chọn hình ảnh cho banner.',
            'image.image' => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes' => 'Định dạng hình ảnh không hợp lệ. Vui lòng tải lên file JPG, JPEG, PNG hoặc WEBP.',
            'image.max' => 'Ảnh không được lớn hơn 2MB.',
            'is_active.required' => 'Vui lòng chọn trạng thái hiển thị.',
            'is_active.in' => 'Giá trị trạng thái không hợp lệ.',
            'location.required' => 'Vui lòng chọn vị trí hiển thị.',
            'location.in' => 'Giá trị vị trí hiển thị không hợp lệ.',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        Banner::create($data);
        return redirect()->route('admin.banners.index')->with('success', 'Thêm banner thành công');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255|unique:banners,title,' . $banner->id,
            'link' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'required|in:0,1',
            'location' => 'required|in:0,1'
        ],[
            'title.required' => 'Vui lòng nhập tên banner.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'title.unique' => 'Tiêu đề này đã tồn tại. Vui lòng chọn tên khác.',
            'link.url' => 'Liên kết không đúng định dạng URL.',
            'image.required' => 'Vui lòng chọn hình ảnh cho banner.',
            'image.image' => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes' => 'Định dạng hình ảnh không hợp lệ. Vui lòng tải lên file JPG, JPEG, PNG hoặc WEBP.',
            'image.max' => 'Ảnh không được lớn hơn 2MB.',
            'is_active.required' => 'Vui lòng chọn trạng thái hiển thị.',
            'is_active.in' => 'Giá trị trạng thái không hợp lệ.',
            'location.required' => 'Vui lòng chọn vị trí hiển thị.',
            'location.in' => 'Giá trị vị trí hiển thị không hợp lệ.',
        ]);

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);
        return redirect()->route('admin.banners.index')->with('success', 'Cập nhật banner thành công');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Xóa banner thành công');
    }
    
}
