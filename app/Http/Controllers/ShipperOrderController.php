<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShipperOrderController extends Controller
{
    public function index()
    {
        $orders = Order::whereIn('status', ['Đang chuẩn bị hàng', 'Đang giao hàng'])
                        ->where(function($q){
                            $q->whereNull('shipper_id')->orWhere('shipper_id', Auth::id());
                        })
                        ->orderByDesc('created_at')
                        ->paginate(10);

        return view('admin.shipper.orders.index', compact('orders'));
    }

    public function create()
    {
        return view('admin.shipper.orders.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'fullname' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'address' => 'required|string|max:255',
        'email' => 'required|email',
        'payment' => 'required|string',
        'total_price' => 'required|numeric',
        'note' => 'nullable|string',
    ]);

    $code = 'ORD-' . strtoupper(uniqid());

    \App\Models\Order::create([
        'fullname' => $request->fullname,
        'phone' => $request->phone,
        'address' => $request->address,
        'email' => $request->email,
        'payment' => $request->payment,
        'total_price' => $request->total_price,
        'note' => $request->note,
        'code' => $code,
        'status' => 'Đang chuẩn bị hàng',
        'payment_status' => 'Chưa thanh toán',
        'user_id' => Auth::id(), // ✅ Thêm dòng này để tránh lỗi
    ]);

    return redirect()->route('admin.shipper.orders.index')->with('success', '✅ Đã thêm đơn hàng thành công.');
}


    public function accept($id)
    {
        $order = Order::where('id', $id)
                    ->whereNull('shipper_id')
                    ->where('status', 'Đang chuẩn bị hàng')
                    ->firstOrFail();

        $order->shipper_id = Auth::id();
        $order->assigned_at = now();
        $order->status = 'Đang giao hàng';
        $order->save();

        return back()->with('success', '✅ Bạn đã nhận đơn hàng thành công.');
    }

    public function complete($id)
    {
        $order = Order::where('id', $id)
                    ->where('shipper_id', Auth::id())
                    ->where('status', 'Đang giao hàng')
                    ->firstOrFail();

        $order->status = 'Đã giao hàng';
        $order->payment_status = 'Đã thanh toán';
        $order->save();

        return back()->with('success', '✅ Giao hàng thành công.');
    }
}
