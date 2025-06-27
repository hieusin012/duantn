<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

// app/Http/Controllers/MessageController.php
class MessageController extends Controller
{
    public function index()
    {
        $adminId = Auth::id();
        $userIds = Message::where('from_user_id', $adminId)
            ->orWhere('to_user_id', $adminId)
            ->pluck('from_user_id')
            ->merge(Message::where('to_user_id', $adminId)->pluck('to_user_id'))
            ->unique()
            ->reject(fn($id) => $id == $adminId);

        $users = User::whereIn('id', $userIds)->get();
        return view('admin.chat.chat', compact('users', 'adminId'));
    }

    public function fetchMessages($userId)
    {
        $messages = Message::with('sender')->where(function ($q) use ($userId) {
            $q->where('from_user_id', Auth::id())
                ->where('to_user_id', $userId);
        })->orWhere(function ($q) use ($userId) {
            $q->where('from_user_id', $userId)
                ->where('to_user_id', Auth::id());
        })->orderBy('created_at')->get();
        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $request->to_user_id,
            'message' => $request->message
        ]);

        return response()->json($message);
    }


    // chat của client

    public function userChatView()
    {
        return view('client.chat');
    }

    public function userFetchMessages()
    {
        $adminId = 1; // Hoặc lấy theo role admin trong hệ thống của bạn
        $userId = Auth::id();

        $messages = Message::where(function ($q) use ($adminId, $userId) {
            $q->where('from_user_id', $userId)
                ->where('to_user_id', $adminId);
        })->orWhere(function ($q) use ($adminId, $userId) {
            $q->where('from_user_id', $adminId)
                ->where('to_user_id', $userId);
        })->orderBy('created_at')->get();

        // Thêm thông tin người gửi vào mỗi tin nhắn
        $messages = $messages->map(function ($msg) use ($adminId) {
            $msg->sender = $msg->from_user_id == $adminId ? 'admin' : 'user';
            return $msg;
        });

        return response()->json($messages);
    }

    public function userSendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $adminId = 1;
        $userId = Auth::id();

        $message = Message::create([
            'from_user_id' => $userId,
            'to_user_id' => $adminId,
            'message' => $request->message,
            'sender' => 'user'
        ]);

        return response()->json($message);
    }
}
