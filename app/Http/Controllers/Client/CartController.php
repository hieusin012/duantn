<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\CartItem;
use App\Models\Voucher;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = Cart::with('items.product', 'items.variant')
            ->where('user_id', Auth::id())
            ->where('status', 'active') // ĐÚNG KIỂU string
            ->first();
        // $voucher = Voucher::where('end_date', '>=', now())->get();
        $voucher = Voucher::where('is_active', 1)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->whereColumn('used', '<', 'quantity') // chỉ hiển thị voucher còn lượt dùng
            ->get();

        $products = Product::where('is_active', 1)
            ->whereNull('deleted_at')
            ->latest()
            ->paginate(12);
        if ($cart) {
            foreach ($cart->items as $item) {
                if (!$item->product || !$item->variant) {
                    $item->forceDelete();
                }
            }
            $cart->load(['items.product', 'items.variant']);
        }


        return view('clients.cart.cart', compact('cart', 'products', 'voucher'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $user = Auth::user();

        // Lấy đúng biến thể từ product_id + color_id + size_id
        $variant = ProductVariant::where('product_id', $request->product_id)
            ->where('color_id', $request->color_id)
            ->where('size_id', $request->size_id)
            ->first();

        if (!$variant) {
            return back()->with('error', 'Không tìm thấy biến thể phù hợp.');
        }

        // Tạo hoặc lấy giỏ hàng
        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
            'status' => 'active', // Thay đổi từ 0 thành 'active'
        ]);
        // $price = $variant->sale_price ?? $variant->price;

        // if (is_null($price)) {
        //     return back()->with('error', 'Không thể thêm sản phẩm chưa có giá.');
        // } 

        $product = Product::findOrFail($request->product_id);
        $isHotDeal = $product->is_hot_deal 
            && $product->discount_percent > 0 
            && $product->deal_end_at 
            && now()->lt($product->deal_end_at);

        // Nếu là Hot Deal → giảm giá theo phần trăm từ variant->price
        if ($isHotDeal) {
            $price = $variant->price * (1 - $product->discount_percent / 100);
        } else {
            // Không phải hot deal → dùng sale_price nếu có, không thì price
            $price = $variant->sale_price ?? $variant->price;
        }

        // Nếu không có giá → báo lỗi
        if (is_null($price)) {
            return back()->with('error', 'Không thể thêm sản phẩm chưa có giá.');
        }
        
        // Kiểm tra xem biến thể đã có trong giỏ hàng chưa
        $item = $cart->items()
            ->where('product_id', $request->product_id)
            ->where('variant_id', $variant->id)
            ->first();

        if ($item) {
            $item->increment('quantity', $request->quantity);
        } else {
            $cart->items()->create([
                'product_id' => $request->product_id,
                'variant_id' => $variant->id,
                'quantity' => $request->quantity,
                'price_at_purchase' => $price,
            ]);
        }
        if ($request->ajax()) {
            $totalQuantity = $cart->items()->count();

            return response()->json([
                'success' => true,
                'total_quantity' => $totalQuantity
            ]);
        }


        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }




    // Cập nhật giỏ hàng
    public function updateCart(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if (!$cart) {
            return redirect()->back()->with('error', 'Không tìm thấy giỏ hàng!');
        }

        foreach ($request->input('quantity', []) as $itemId => $quantity) {
            $item = CartItem::find($itemId);
            if ($item && $item->cart_id == $cart->id) {
                $item->quantity = $quantity;
                $item->save();
            }
        }

        return redirect()->back()->with('success', 'Cập nhật giỏ hàng thành công!');
    }


    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($productId)
    {

        $item = CartItem::with('cart')->find($productId);

        if (!$item) {
            return back()->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng.');
        }
        if (!$item->cart || $item->cart->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xóa sản phẩm này.');
        }
        $item->update(['status' => 'Đã xóa']);
        $item->delete();

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }
}
