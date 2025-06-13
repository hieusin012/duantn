<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ContactMessageMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // Hiển thị form liên hệ
    public function showForm()
    {
        return view('clients.contact'); // Cập nhật theo đúng view bạn đang dùng
    }

    // Xử lý dữ liệu form
    public function handleSubmit(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string|min:10',
        ]);

        // Gửi email đến admin
        Mail::to(env('MAIL_RECEIVER'))->send(new ContactMessageMail($validated));

        // Redirect lại với thông báo thành công
        return redirect()->back()->with('success', 'Cảm ơn bạn đã liên hệ với chúng tôi!');
    }
}
