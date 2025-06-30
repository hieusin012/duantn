<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderLookupController extends Controller
{
    public function form()
    {
        return view('clients.order.lookup-form');
    }

    public function lookup(Request $request)
    {
        $request->validate([
            'order_code' => 'required|string|max:10',
            'email_or_phone' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL) && !preg_match('/^[0-9]{9,11}$/', $value)) {
                        $fail('Email hoặc SĐT không hợp lệ.');
                    }
                }
            ]
        ], [
            'order_code.required' => 'Vui lòng nhập mã đơn hàng.',
            'order_code.max' => 'Mã đơn hàng không được vượt quá 10 ký tự.',
            'email_or_phone.required' => 'Vui lòng nhập email hoặc số điện thoại.',
        ]);

        $order = Order::where('code', $request->order_code)
            ->where(function ($q) use ($request) {
                $q->where('email', $request->email_or_phone)
                ->orWhere('phone', $request->email_or_phone);
            })
            ->first();

        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng. Vui lòng kiểm tra lại.');
        }

        return view('clients.order.lookup-result', compact('order'));
    }

}

