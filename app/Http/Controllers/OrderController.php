<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        // Filter by keyword
        if ($keyword = $request->keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('code', 'like', "%{$keyword}%")
                  ->orWhere('fullname', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by total price
        if ($request->min_price) {
            $query->where('total_price', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $query->where('total_price', '<=', $request->max_price);
        }

        $orders = $query->latest()->paginate(10);
        $users = User::all();

        return view('admin.orders.index', compact('orders', 'users'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.orders.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:50',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:199',
            'email' => 'required|email|max:199',
            'payment' => 'required|in:Thanh toán khi nhận hàng,Thanh toán bằng thẻ,Thanh toán qua VNPay',
            'status' => 'required|in:Chờ xác nhận,Đã xác nhận,Đang chuẩn bị hàng,Đang giao hàng,Đã giao hàng,Đơn hàng đã hủy',
            'payment_status' => 'required|in:Chưa thanh toán,Đã thanh toán',
            'shiping' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'total_price' => 'required|numeric',
            'note' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $validated['code'] = 'ORD-' . Str::random(8);
        Order::create($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Order created successfully');
    }

    public function show(Order $order)
    {
        $order->load('user');
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $users = User::all();
        return view('admin.orders.edit', compact('order', 'users'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:50',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:199',
            'email' => 'required|email|max:199',
            'payment' => 'required|in:Thanh toán khi nhận hàng,Thanh toán bằng thẻ,Thanh toán qua VNPay',
            'status' => 'required|in:Chờ xác nhận,Đã xác nhận,Đang chuẩn bị hàng,Đang giao hàng,Đã giao hàng,Đơn hàng đã hủy',
            'payment_status' => 'required|in:Chưa thanh toán,Đã thanh toán',
            'shiping' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'total_price' => 'required|numeric',
            'note' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully');
    }
}