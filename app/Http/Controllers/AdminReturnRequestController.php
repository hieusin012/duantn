<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnRequest;

class AdminReturnRequestController extends Controller
{
    public function index()
    {
        $requests = ReturnRequest::with('user', 'order')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.return_requests.index', compact('requests'));
    }

    public function show($id)
    {
        $request = ReturnRequest::with('user', 'order')->findOrFail($id);
        return view('admin.return_requests.show', compact('request'));
    }

    // public function update(Request $request, $id)
    // {
    //     $return = ReturnRequest::findOrFail($id);
    //     $return->update([
    //         'status' => $request->status,
    //         'admin_note' => $request->admin_note,
    //     ]);

    //     // Nếu chọn trạng thái "refunded" thì cập nhật đơn hàng liên quan
    //     if ($request->status === 'refunded' && $return->order) {
    //         $return->order->update([
    //             'status' => 'Đã hoàn hàng',
    //             'payment_status' => 'Đã hoàn tiền',
    //         ]);
    //     }

    //     return redirect()->route('admin.return-requests.index')->with('success', 'Cập nhật thành công');
    // }

    public function update(Request $request, $id)
    {
        $return = ReturnRequest::findOrFail($id);
        $oldStatus = $return->status;
        $newStatus = $request->status;

        // Nếu đã hoàn tiền rồi thì không cho sửa
        if ($oldStatus === 'refunded' && $newStatus !== 'refunded') {
            return back()->with('error', 'Không thể thay đổi trạng thái sau khi đã hoàn tiền.');
        }

        // Không cho từ "rejected" nhảy thẳng sang "refunded"
        if ($oldStatus === 'rejected' && $newStatus === 'refunded') {
            return back()->with('error', 'Không thể hoàn tiền với yêu cầu đã bị từ chối.');
        }

        // Cập nhật trạng thái và ghi chú
        $return->update([
            'status' => $newStatus,
            'admin_note' => $request->admin_note,
        ]);

        // Nếu chuyển sang "refunded", cập nhật đơn hàng liên quan
        if ($newStatus === 'refunded' && $return->order) {
            $return->order->update([
                'status' => 'Đã hoàn hàng',
                'payment_status' => 'Đã hoàn tiền',
            ]);
        }

        return redirect()->route('admin.return-requests.index')->with('success', 'Cập nhật trạng thái thành công.');
    }
}

