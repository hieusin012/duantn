<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function index($orderId)
    {
        $order = Order::findOrFail($orderId);
        $orderDetails = OrderDetail::with('variant')->where('order_id', $orderId)->paginate(10);
        $variants = ProductVariant::all();

        return view('admin.order_details.index', compact('order', 'orderDetails', 'variants'));
    }

    public function create($orderId)
    {
        $order = Order::findOrFail($orderId);
        $variants = ProductVariant::all();
        return view('admin.order_details.create', compact('order', 'variants'));
    }

    public function store(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $validated = $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $variantId = $validated['variant_id'];
        // Check if the variant already exists in the order
        if (OrderDetail::where('order_id', $orderId)->where('variant_id', $variantId)->exists()) {
            return back()->withErrors(['variant_id' => 'Biến thể này đã tồn tại trong đơn hàng.']);
        }

        $validated['order_id'] = $orderId;
        $validated['total_price'] = $validated['quantity'] * $validated['price'];

        OrderDetail::create($validated);

        // Update order total_price
        $order->total_price = $order->orderDetails()->sum('total_price');
        $order->save();

        return redirect()->route('admin.orders.details.index', $orderId)
            ->with('success', 'Thêm chi tiết đơn hàng thành công');
    }

    public function edit($orderId, $variantId)
    {
        $order = Order::findOrFail($orderId);
        $orderDetail = OrderDetail::where('order_id', $orderId)->where('variant_id', $variantId)->firstOrFail();
        $variants = ProductVariant::all();
        return view('admin.order_details.edit', compact('order', 'orderDetail', 'variants'));
    }

    public function update(Request $request, $orderId, $variantId)
    {
        $order = Order::findOrFail($orderId);
        $orderDetail = OrderDetail::where('order_id', $orderId)->where('variant_id', $variantId)->firstOrFail();

        $validated = $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        // Check if the new variant_id already exists in the order (excluding current record)
        if ($validated['variant_id'] != $variantId && OrderDetail::where('order_id', $orderId)->where('variant_id', $validated['variant_id'])->exists()) {
            return back()->withErrors(['variant_id' => 'Biến thể này đã tồn tại trong đơn hàng.']);
        }

        $validated['total_price'] = $validated['quantity'] * $validated['price'];

        // Update the record
        $orderDetail->update([
            'variant_id' => $validated['variant_id'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
            'total_price' => $validated['total_price'],
        ]);

        // Update order total_price
        $order->total_price = $order->orderDetails()->sum('total_price');
        $order->save();

        return redirect()->route('admin.orders.details.index', $orderId)
            ->with('success', 'Cập nhật chi tiết đơn hàng thành công');
    }

    public function destroy($orderId, $variantId)
    {
        $order = Order::findOrFail($orderId);
        $orderDetail = OrderDetail::where('order_id', $orderId)->where('variant_id', $variantId)->firstOrFail();
        $orderDetail->delete();

        // Update order total_price
        $order->total_price = $order->orderDetails()->sum('total_price');
        $order->save();

        return redirect()->route('admin.orders.details.index', $orderId)
            ->with('success', 'Xóa chi tiết đơn hàng thành công');
    }
}