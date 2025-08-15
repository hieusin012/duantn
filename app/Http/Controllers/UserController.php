<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('fullname', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%")
                ->orWhere('phone', 'like', "%{$keyword}%");
            });
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }


    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $data['password'] = Hash::make($request->password);
        $data['status'] = $request->input('status', 'active'); // FIX HERE
        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Tạo người dùng thành công.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        // Chặn admin thay đổi role/status admin khác
        if (Auth::user()->role === 'admin' && $user->role === 'admin') {
            unset($data['role']);
            unset($data['status']);
        } else {
            // Nếu là tạo hoặc sửa user member, nhận giá trị từ request
            $data['role'] = $request->input('role', 'member');
            $data['status'] = $request->input('status', 'active');
        }

        // $data['status'] = $request->input('status', 'active'); // FIX HERE

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Chỉnh sửa người dùng thành công.');
    }
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                            ->with('error', 'Bạn không thể xóa tài khoản đang đăng nhập.');
        }
        if ($user->role === 'admin' && Auth::user()->role !== 'super_admin') {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa tài khoản admin khác!');
        }
        // if ($user->orders()->exists()) {
        //     return redirect()->route('admin.users.index')
        //         ->with('error', 'Không thể xóa tài khoản vì có đơn hàng liên quan');
        // }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Xóa người dùng thành công.');
    }
    public function deleted()
    {
        $deletedUsers = User::onlyTrashed()->get();
        return view('admin.users.deleted', compact('deletedUsers'));
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('admin.users.index')->with('success', 'Khôi phục người dùng thành công!');
    }

    public function eliminate($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect()->route('admin.users.deleted')->with('success', 'Xóa vĩnh viễn người dùng thành công!');
    }

    public function forceDeleteAll()
    {
        $deletedUsers = User::onlyTrashed()->get();
        foreach ($deletedUsers as $user) {
            $user->forceDelete();
        }
        return redirect()->route('admin.users.deleted')->with('success', 'Đã xóa vĩnh viễn tất cả người dùng đã xóa mềm!');
    }


    
}