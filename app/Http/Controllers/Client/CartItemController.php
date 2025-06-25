<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductVariant;

class CartItemController extends Controller
{
    // Thêm sản phẩm vào giỏ hàng
    public function hasDeleted()
    {
        $deletedItems = CartItem::onlyTrashed()
            ->whereHas('cart', function ($query) {
                $query->where('user_id', Auth::id())
                    ->where('status', 0); // Chỉ lấy giỏ hàng chưa thanh toán
            })
            ->get();

        return view('clients.cart.has-deleted', compact('deletedItems'));
    }
    public function forceDelete($id)
    {
        $item = CartItem::withTrashed()->find($id);
        if (!$item || !$item->trashed()) {
            return back()->with('error', 'Không tìm thấy sản phẩm đã xóa.');
        }
        $item->forceDelete();
        return redirect()->route('client.cart.hasdelete')->with('success', 'Đã xóa vĩnh viễn sản phẩm khỏi giỏ hàng.');
    }
    public function forceDeleteSelected(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array'
        ]);
        $selectedItems = $request->input('selected_items', []);
        if (empty($selectedItems)) {
            return back()->with('error', 'Vui lòng chọn ít nhất một sản phẩm để xóa vĩnh viễn.');
        }
        $deletedCount = 0;
        foreach ($selectedItems as $itemId) {
            $item = CartItem::withTrashed()->find($itemId);
            if ($item && $item->trashed()) {
                $item->forceDelete();
                $deletedCount++;
            }
        }
        if ($deletedCount === 0) {
            return back()->with('error', 'Không có sản phẩm nào được xóa vĩnh viễn.');
        }

        return redirect()->route('client.cart.hasdelete')->with('success', "Đã xóa vĩnh viễn {$deletedCount} sản phẩm.");
    }
    public function restoreSelected(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array'
        ]);
        $selectedItems = $request->input('selected_items', []);
        if (empty($selectedItems)) {
            return back()->with('error', 'Vui lòng chọn ít nhất một sản phẩm để khôi phục.');
        }
        $restoredCount = 0;
        foreach ($selectedItems as $itemId) {
            $item = CartItem::withTrashed()->find($itemId);
            if ($item && $item->trashed()) {
                $item->restore();
                $restoredCount++;
            }
        }
        if ($restoredCount === 0) {
            return back()->with('error', 'Không có sản phẩm nào được khôi phục.');
        }

        return redirect()->route('client.cart.hasdelete')->with('success', "Đã khôi phục {$restoredCount} sản phẩm.");
    }
}