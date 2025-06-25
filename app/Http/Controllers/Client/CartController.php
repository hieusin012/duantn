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

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = Cart::with('items.product', 'items.variant')->where([
            'user_id' => Auth::id(),
            'status' => 0
        ])->first();
        $products = Product::where('is_active', 1)
            ->whereNull('deleted_at')
            ->latest()
            ->paginate(12);

        return view('clients.cart.cart', compact('cart', 'products'));
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
            'status' => 0, // trạng thái "chưa thanh toán"
        ]);
        $price = $variant->sale_price ?? $variant->price;

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


        return redirect()->route('client.cart')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }




    // Cập nhật giỏ hàng
    public function updateCart(Request $request)
    {
        $request->validate([
            'selected' => 'array',
            'quantity' => 'array',
            'quantity.*' => 'integer|min:1'
        ]);
        $cart = Cart::with('items')->where([
            'user_id' => Auth::id(),
            'status' => 0
        ])->first();
        if (!$cart) {
            return back()->with('error', 'Giỏ hàng không tồn tại.');
        }
        $selectedItems = $request->input('selected', []);
        $quantities = $request->input('quantity', []);
        if (empty($selectedItems)) {
            return back()->with('error', 'Vui lòng chọn ít nhất một sản phẩm để cập nhật.');
        }
        $totalPrice = 0;
        $totalQuantity = 0;
        foreach ($cart->items as $item) {
            if (in_array($item->id, $selectedItems)) {
                $quantity = isset($quantities[$item->id]) ? (int)$quantities[$item->id] : 1;
                if ($quantity <= 0) {
                    $item->delete();
                } else {
                    $item->update(['quantity' => $quantity]);
                }
                $totalQuantity += $quantity;
                $totalPrice += $item->price_at_purchase * $quantity;
            }
        }
        if ($totalQuantity === 0) {
            $cart->delete(); // Xóa giỏ hàng nếu không còn sản phẩm nào
            return redirect()->route('client.cart')->with('success', 'Giỏ hàng đã được cập nhật và trống.');
        }
        return redirect()->route('client.cart')->with('success', 'Giỏ hàng đã được cập nhật thành công!')->with(['total_price' => $totalPrice,]);
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

        $item->delete();

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }
    
}
