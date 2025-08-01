@extends('admin.layouts.index')

@section('title', 'Chi tiết người dùng')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="tile shadow-sm p-4 rounded bg-white">
            <h3 class="tile-title text-primary mb-4">👤 Thông tin chi tiết người dùng</h3>

            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary mb-3">
                <i class="bx bx-arrow-back"></i> Quay lại danh sách
            </a>

            <div class="tile-body">
                @if($user->avatar)
                    <div class="mb-4 text-center">
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar"
                             class="rounded-circle border shadow"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <tbody>
                            <tr><th scope="row">🆔 ID</th><td>{{ $user->id }}</td></tr>
                            <tr><th>👤 Họ tên</th><td>{{ $user->fullname }}</td></tr>
                            <tr><th>🖼️ Ảnh đại diện</th>
                                <td>
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}"
                                             class="rounded border"
                                             style="max-width: 100px;" alt="Avatar nhỏ">
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr><th>📞 Số điện thoại</th><td>{{ $user->phone ?? '-' }}</td></tr>
                            <tr><th>🏠 Địa chỉ</th><td>{{ $user->address ?? '-' }}</td></tr>
                            <tr><th>📧 Email</th><td>{{ $user->email }}</td></tr>
                            <tr><th>✅ Xác thực Email</th>
                                <td>{{ $user->email_verified_at ? $user->email_verified_at->format('d/m/Y H:i:s') : 'Chưa xác thực' }}</td>
                            </tr>
                            <tr><th>🔐 Mật khẩu (hash)</th><td><code>{{ $user->password }}</code></td></tr>
                            <tr><th>👑 Vai trò</th><td>{{ $user->role === 'admin' ? 'Admin' : 'User' }}</td></tr>
                            <tr><th>⚙️ Trạng thái</th><td>
                                {{-- <span class="badge {{ $user->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->status == 1 ? 'Hoạt động' : 'Tạm khóa' }}
                                </span> --}}
                                <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->status === 'active' ? 'Hoạt động' : 'Tạm khóa' }}
                                </span>
                            </td></tr>
                            <tr><th>🔢 OTP</th><td>{{ $user->otp ?? '-' }}</td></tr>
                            <tr><th>🔗 Google ID</th><td>{{ $user->google_id ?? '-' }}</td></tr>
                            <tr><th>🚻 Giới tính</th>
                                <td>
                                    @switch($user->gender)
                                        @case('Nam') Nam @break
                                        @case('Nữ') Nữ @break
                                        @case('Khác') Khác @break
                                        @default -
                                    @endswitch
                                </td>
                            </tr>
                            <tr><th>🎂 Ngày sinh</th><td>{{ $user->birthday ? $user->birthday->format('d/m/Y') : '-' }}</td></tr>
                            <tr><th>🌐 Ngôn ngữ</th><td>{{ $user->language ?? '-' }}</td></tr>
                            <tr><th>📝 Giới thiệu</th><td>{{ $user->introduction ?? '-' }}</td></tr>
                            <tr><th>🔐 Remember Token</th><td><code>{{ $user->remember_token ?? '-' }}</code></td></tr>
                            <tr><th>🕒 Tạo lúc</th><td>{{ $user->created_at->format('d/m/Y H:i:s') }}</td></tr>
                            <tr><th>🔄 Cập nhật lúc</th><td>{{ $user->updated_at->format('d/m/Y H:i:s') }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
