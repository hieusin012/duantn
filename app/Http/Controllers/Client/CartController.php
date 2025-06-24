<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = Cart::with('items.product', 'items.variant')->where([
            'user_id' => Auth::id(),
            'status' => 0
        ])->first();

        return view('clients.cart.cart', compact('cart'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);
        $user = Auth::user();

        // Lấy hoặc tạo giỏ hàng hiện tại
        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
            'status' => 0
        ]);

        // Kiểm tra item đã có chưa
        $item = $cart->items()->where('product_id', $request->product_id)
            ->where('variant_id', $request->variant_id)
            ->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            $product = Product::findOrFail($request->product_id);

            $cart->items()->create([
                'product_id' => $product->id,
                'variant_id' => $request->variant_id,
                'quantity' => 1,
                'price_at_purchase' => $product->price
            ]);
        }

        return redirect()->route('client.cart')->with('success', 'Đã thêm vào giỏ hàng!');
    }


    // Cập nhật giỏ hàng
    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        foreach ($request->input('quantities', []) as $productId => $quantity) {
            if (isset($cart[$productId])) {
                if ($quantity <= 0) {
                    unset($cart[$productId]);
                } else {
                    $cart[$productId]['quantity'] = $quantity;
                }
            }
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Giỏ hàng đã được cập nhật!');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
        }
        return redirect()->back()->withErrors(['error' => 'Sản phẩm không tồn tại trong giỏ hàng!']);
    }
}
