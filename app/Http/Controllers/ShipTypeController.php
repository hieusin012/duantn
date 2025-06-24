<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShipType;
use Illuminate\Http\Request;

class ShipTypeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $shipTypes = ShipType::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%");
        })->paginate(10);

        return view('admin.shiptypes.index', compact('shipTypes', 'search'));
    }

    public function create()
    {
        return view('admin.shiptypes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        ShipType::create($request->only('name', 'price'));
        return redirect()->route('admin.shiptypes.index')->with('success', 'Thêm loại ship thành công.');
    }

    public function edit($id)
    {
        $shipType = ShipType::findOrFail($id);
        return view('admin.shiptypes.edit', compact('shipType'));
    }

    public function update(Request $request, $id)
    {
        $shipType = ShipType::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $shipType->update($request->only('name', 'price'));
        return redirect()->route('admin.shiptypes.index')->with('success', 'Cập nhật loại ship thành công.');
    }

    public function destroy($id)
    {
        ShipType::destroy($id);
        return redirect()->route('admin.shiptypes.index')->with('success', 'Xóa loại ship thành công.');
    }
}
