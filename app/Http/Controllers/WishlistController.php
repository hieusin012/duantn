<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $wishlists = $user->wishlists()->with('product')->latest()->get();

        return view('clients.wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $productId = $request->product_id;

        $wishlist = $user->wishlists()->where('product_id', $productId)->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
        } else {
            $user->wishlists()->create([
                'product_id' => $productId
            ]);
            $status = 'added';
        }

        $count = $user->wishlists()->count();

        return response()->json([
            'status' => $status,
            'count' => $count
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        /** @var User $user */
        $user = Auth::user();

        $user->wishlists()->where('product_id', $request->product_id)->delete();

        return redirect()->back()->with('success', 'Đã xóa khỏi danh sách yêu thích');
    }
}
