<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ShipperController extends Controller
{
    public function index()
    {
        $shippers = User::where('role', 'shipper')->orderByDesc('id')->paginate(10);
        return view('admin.shippers.index', compact('shippers'));
    }

    public function create()
    {
        return view('admin.shipper.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'required|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'shipper',
        ]);

        return redirect()->route('shipper.index')->with('success', '✅ Thêm shipper thành công.');
    }

    public function edit($id)
    {
        $shipper = User::where('role', 'shipper')->findOrFail($id);
        return view('admin.shipper.edit', compact('shipper'));
    }

    public function update(Request $request, $id)
    {
        $shipper = User::where('role', 'shipper')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $shipper->name = $request->name;
        $shipper->phone = $request->phone;

        if ($request->filled('password')) {
            $shipper->password = Hash::make($request->password);
        }

        $shipper->save();

        return redirect()->route('shipper.index')->with('success', '✅ Cập nhật shipper thành công.');
    }

    public function destroy($id)
    {
        $shipper = User::where('role', 'shipper')->findOrFail($id);
        $shipper->delete();

        return redirect()->route('shipper.index')->with('success', '✅ Xóa shipper thành công.');
    }
}
