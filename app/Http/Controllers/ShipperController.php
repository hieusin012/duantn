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
        return view('admin.shipper.persons.index', compact('shippers'));
    }

    public function create()
    {
        return view('admin.shipper.persons.create');
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
        'fullname' => $request->name, // hoặc $request->fullname nếu có input riêng
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'phone' => $request->phone,
        'role' => 'shipper',
    ]);


        return redirect()->route('admin.shipper.persons.index')->with('success', '✅ Thêm shipper thành công.');
    }

    public function edit($id)
    {
         $shipper = User::where('role', 'shipper')->findOrFail($id);
        return view('admin.shipper.persons.edit', compact('shipper'));
    }

    public function update(Request $request, $id)
    {
         $shipper = User::where('role', 'shipper')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'password' => 'nullable|min:6',
        ]);

        $shipper->fullname = $request->name;
        $shipper->phone = $request->phone;
        $shipper->status = $request->status;


        if ($request->filled('password')) {
            $shipper->password = Hash::make($request->password);
        }

        $shipper->save();

        return redirect()->route('admin.shipper.persons.index')
            ->with('success', '✅ Cập nhật shipper thành công.');
    }

    public function destroy($id)
    {
       $shipper = User::where('role', 'shipper')->findOrFail($id);
        $shipper->delete();

        return redirect()->route('admin.shipper.persons.index')
            ->with('success', '✅ Xóa shipper thành công.');
    }
}
