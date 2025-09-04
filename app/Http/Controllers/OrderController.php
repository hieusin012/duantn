<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        // Filter by keyword
        if ($keyword = $request->keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('code', 'like', "%{$keyword}%")
                    ->orWhere('fullname', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('phone', 'like', "%{$keyword}");
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
            'status' => 'required|in:Chờ xác nhận,Đã xác nhận,Đang chuẩn bị hàng,Đang giao hàng,Đã giao hàng,Đơn hàng đã hủy,Đã hoàn hàng',
            'payment_status' => 'required|in:Chưa thanh toán,Đã thanh toán,Đã hoàn tiền',
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
            'status' => 'required|in:Chờ xác nhận,Đã xác nhận,Đang chuẩn bị hàng,Đang giao hàng,Đã giao hàng,Đơn hàng đã hủy,Đã hoàn hàng',
            'payment_status' => 'required|in:Chưa thanh toán,Đã thanh toán,Đã hoàn tiền',
            'shipping' => 'nullable|numeric',  // ✅ Sửa đúng chính tả
            'discount' => 'nullable|numeric',
            'total_price' => 'required|numeric',
            'note' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được cập nhật thành công.');
    }



    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully');
    }

    public function report(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->endOfMonth()->format('Y-m-d');

        $orders = Order::where('status', 'Đã giao hàng')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->get();

        $totalRevenue = $orders->sum('total_price');
        $totalOrders = $orders->count();

        return view('admin.thongkedoanhthu.report', compact('orders', 'totalRevenue', 'totalOrders', 'startDate', 'endDate'));
    }

    // public function cancel($id)
    // {
    //     $order = Order::where('id', $id)
    //         ->where('user_id', Auth::id())
    //         ->where('status', 'Chờ xác nhận')
    //         ->first();

    //     if (!$order) {
    //         return back()->with('error', 'Không thể hủy đơn hàng.');
    //     }

    //     // ✅ Cộng lại tồn kho cho từng biến thể sản phẩm
    //     foreach ($order->orderDetails as $detail) {
    //         ProductVariant::where('id', $detail->variant_id)
    //             ->increment('quantity', $detail->quantity);
    //     }

    //     $order->status = 'Đơn hàng đã hủy';
    //     $order->save();

    //     return back()->with('success', 'Đơn hàng đã được hủy thành công.');
    // }
    public function cancel(Request $request, $id)
    {
        $order = Order::with('orderDetails')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->where(function ($query) {
                $query->where('status', 'Chờ xác nhận')
                    ->orWhere('status', 'Đã xác nhận');
            })
            ->first();

        if (!$order) {
            return back()->with('error', 'Không thể hủy đơn hàng.');
        }

        // ✅ Cộng lại tồn kho
        foreach ($order->orderDetails as $detail) {
            ProductVariant::where('id', $detail->variant_id)
                ->increment('quantity', $detail->quantity);
        }

        // ✅ Lưu trạng thái + lý do hủy
        $order->status = 'Đơn hàng đã hủy';
        if($order->payment == 'Thanh toán qua VNPay'){
            $order->payment_status = 'Đã hoàn tiền';
        }
        $order->cancel_reason = $request->cancel_reason;
        $order->cancel_note   = $request->cancel_note;
        $order->save();

        return back()->with('success', 'Đơn hàng đã được hủy thành công.');
    }


    public function updateStatus(Order $order)
    {
        // Danh sách trạng thái đơn hàng và thanh toán
        $statuses = [
            'Chờ xác nhận',
            'Đã xác nhận',
            'Đang chuẩn bị hàng',
            'Đang giao hàng',
            'Đã giao hàng',
        ];

        $paymentStatuses = [
            'Chưa thanh toán',
            'Đã thanh toán',
        ];

        // Tìm chỉ số trạng thái hiện tại
        $currentStatusIndex = array_search($order->status, $statuses);
        $currentPaymentIndex = array_search($order->payment_status, $paymentStatuses);

        // Nếu trạng thái hiện tại tồn tại trong danh sách và chưa phải cuối cùng
        if ($currentStatusIndex !== false && $currentStatusIndex < count($statuses) - 1) {
            $nextStatus = $statuses[$currentStatusIndex + 1];
            $order->status = $nextStatus;

            // Nếu trạng thái mới là "Đã giao hàng" thì cập nhật trạng thái thanh toán
            // if ($nextStatus === 'Đã giao hàng' && $currentPaymentIndex === 0) {
            //     $order->payment_status = $paymentStatuses[1]; // Đã thanh toán
            // }
            if ($nextStatus === 'Đã giao hàng') {
                // Nếu đơn chưa có thời gian giao thì gán thời gian hiện tại
                if (!$order->delivered_at) {
                    $order->delivered_at = now();
                }

                // Nếu trạng thái thanh toán là "Chưa thanh toán", cập nhật sang "Đã thanh toán"
                if ($currentPaymentIndex === 0) {
                    $order->payment_status = $paymentStatuses[1];
                }
            }

            $order->save();

            return back()->with('success', 'Trạng thái đơn hàng đã được cập nhật thành công.');
        }

        return back()->with('error', 'Không thể cập nhật trạng thái đơn hàng.');
    }
    //hủy đơn hàng
    public function cancelAdmin(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        // Hủy đơn
        $order->update([
            'status' => 'Đơn hàng đã hủy',
            'cancel_reason' => 'Admin hủy',
            'cancel_note' => 'Khách hàng không nhận hàng',
        ]);
        $order->orderDetails->each(function ($detail) {
            $variant = ProductVariant::find($detail->variant_id);
            if ($variant) {
                $variant->increment('quantity', $detail->quantity);
            }
        });


        return back()->with('success', 'Đơn hàng đã được hủy thành công.');
    }

    // in dữ liệu
    // OrderController.php
    public function print($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.orders.print', compact('order'));
    }

    // Hoàn hàng tự động
    // public function acceptReturn($id)
    // {
    //     $order = Order::findOrFail($id);

    //     if ($order->status === 'Đã giao hàng') {
    //         $order->status = 'Đã hoàn hàng';
    //         $order->payment_status = 'Đã hoàn tiền';
    //         $order->save();

    //         return back()->with('success', 'Đơn hàng đã được cập nhật sang trạng thái "Đã hoàn hàng" và đã hoàn tiền.');
    //     }

    //     return back()->with('error', 'Chỉ có thể hoàn hàng khi đơn hàng đã giao.');
    // }
    public function acceptReturn($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'Đã giao hàng') {
            return back()->with('error', 'Chỉ có thể hoàn hàng khi đơn hàng đã giao.');
        }

        // Kiểm tra nếu đã quá 7 ngày kể từ ngày giao hàng
        if ($order->delivered_at && now()->diffInDays($order->delivered_at) > 7) {
            return back()->with('error', 'Đơn hàng đã quá thời gian hoàn hàng (7 ngày).');
        }

        $order->status = 'Đã hoàn hàng';
        $order->payment_status = 'Đã hoàn tiền';
        $order->save();

        return back()->with('success', 'Đơn hàng đã được cập nhật sang trạng thái "Đã hoàn hàng" và đã hoàn tiền.');
    }
}
