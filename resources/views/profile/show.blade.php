@extends('clients.layouts.master')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-light text-white">
                    <h4 class="mb-0 text-center">Hồ sơ cá nhân</h4>
                </div>
                
                <div class="card-body row">
                    {{-- Avatar trái --}}
                    <div class="col-md-4 text-center">
                        @if($user->avatar)
                        {{-- <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="img-fluid rounded-circle mb-3" style="max-width: 180px;"> --}}
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                        @else
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 180px; height: 180px;">
                            <span class="text-muted">Chưa có ảnh</span>
                        </div>
                        @endif
                    </div>

                    {{-- Thông tin phải --}}
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <th>Họ tên:</th>
                                <td>{{ $user->fullname }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Điện thoại:</th>
                                <td>{{ $user->phone }}</td>
                            </tr>
                            <tr>
                                <th>Địa chỉ:</th>
                                <td>{{ $user->address }}</td>
                            </tr>
                            <tr>
                                <th>Giới tính:</th>
                                <td>{{ $user->gender }}</td>
                            </tr>
                            <tr>
                                <th>Ngày sinh:</th>
                                <td>{{ $user->birthday }}</td>
                            </tr>
                            <tr>
                                <th>Ngôn ngữ:</th>
                                <td>{{ $user->language }}</td>
                            </tr>
                            <tr>
                                <th>Giới thiệu:</th>
                                <td>{{ $user->introduction }}</td>
                            </tr>
                        </table>

                        <div class="row">
                            <div class="col text-start">
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary mt-3">
                                    <i class="bi bi-pencil-square"></i> Chỉnh sửa hồ sơ
                                </a>
                            </div>
                            <div class="col text-end">
                                <a href="{{ route('profile.change-password.form') }}" class="btn btn-outline-danger mt-3 ms-auto">
                                    <i class="bi bi-pencil-square"></i> Đổi mật khẩu
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection