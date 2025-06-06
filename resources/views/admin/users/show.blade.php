@extends('admin.layouts.index')

@section('title', 'Chi tiết người dùng')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Chi tiết người dùng</h3>

            <a href="{{ route('admin.users.index') }}" class="btn btn-cancel btn-sm mb-3">
                <i class="fas fa-undo"></i> Quay lại danh sách
            </a>

            <div class="tile-body">
                @if($user->avatar)
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" style="max-width: 150px; border-radius: 8px;">
                    </div>
                @endif

                <table class="table table-bordered">
                    <tbody>
                        <tr><th>ID</th><td>{{ $user->id }}</td></tr>
                        <tr><th>Fullname</th><td>{{ $user->fullname }}</td></tr>
                        <tr><th>Avatar</th><td>
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" style="max-width: 100px; border-radius: 8px;">
                            @else
                                -
                            @endif
                        </td></tr>
                        <tr><th>Phone</th><td>{{ $user->phone ?? '-' }}</td></tr>
                        <tr><th>Address</th><td>{{ $user->address ?? '-' }}</td></tr>
                        <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                        <tr><th>Email Verified At</th><td>{{ $user->email_verified_at ? $user->email_verified_at->format('d/m/Y H:i:s') : 'Chưa xác thực' }}</td></tr>
                        <tr><th>Password (hashed)</th><td><code>{{ $user->password }}</code></td></tr>
                        <tr><th>Role</th><td>{{ $user->role === 'admin' ? 'Admin' : 'User' }}</td></tr>
                        <tr><th>Status</th><td>{{ $user->status == 1 ? 'Hoạt động' : 'Tạm khóa' }}</td></tr>
                        <tr><th>OTP</th><td>{{ $user->otp ?? '-' }}</td></tr>
                        <tr><th>Google ID</th><td>{{ $user->google_id ?? '-' }}</td></tr>
                        <tr><th>Gender</th><td>
                            @switch($user->gender)
                                @case('Nam') Nam @break
                                @case('Nữ') Nữ @break
                                @case('Khác') Khác @break
                                @default -
                            @endswitch
                        </td></tr>
                        <tr><th>Birthday</th><td>{{ $user->birthday ? $user->birthday->format('d/m/Y') : '-' }}</td></tr>
                        <tr><th>Language</th><td>{{ $user->language ?? '-' }}</td></tr>
                        <tr><th>Introduction</th><td>{{ $user->introduction ?? '-' }}</td></tr>
                        <tr><th>Remember Token</th><td><code>{{ $user->remember_token ?? '-' }}</code></td></tr>
                        <tr><th>Created At</th><td>{{ $user->created_at->format('d/m/Y H:i:s') }}</td></tr>
                        <tr><th>Updated At</th><td>{{ $user->updated_at->format('d/m/Y H:i:s') }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
