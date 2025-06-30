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
    // Xoá tất cả tin nhắn giữa admin và 1 user
    public function deleteConversationWithUser($userId)
    {
        $adminId = Auth::id(); // hoặc truyền qua request nếu cần

        // Xoá tất cả messages giữa admin và user đó (2 chiều)
        Message::where(function ($query) use ($userId, $adminId) {
            $query->where('from_user_id', $adminId)
                ->where('to_user_id', $userId);
        })->orWhere(function ($query) use ($userId, $adminId) {
            $query->where('from_user_id', $userId)
                ->where('to_user_id', $adminId);
        })->delete();

        return back()->with('success', 'Đã xoá toàn bộ cuộc trò chuyện với user.');
    }



    // chat của client
    public function send(Request $request)
    {
        $from = Auth::id();
        $admin = \App\Models\User::where('role', 'admin')->first();
        $to = $admin?->id;


        Message::create([
            'from_user_id' => $from,
            'to_user_id' => $to,
            'message' => $request->message,
        ]);

        return response()->json(['status' => 'ok']);
    }

    public function fetch()
    {
        $userId = Auth::id();
        $admin = \App\Models\User::where('role', 'admin')->first();
        $adminId = $admin?->id;

        // Lấy tất cả tin giữa user và admin
        $messages = Message::where(function ($q) use ($userId, $adminId) {
            $q->where('from_user_id', $userId)->where('to_user_id', $adminId);
        })->orWhere(function ($q) use ($userId, $adminId) {
            $q->where('from_user_id', $adminId)->where('to_user_id', $userId);
        })->orderBy('created_at')->get();

        return response()->json($messages);
    }
}
