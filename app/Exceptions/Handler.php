<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    protected $levels = [];

    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
{
    if ($exception instanceof ModelNotFoundException) {
        // Nếu là trang chi tiết sản phẩm => redirect kèm thông báo
        if ($request->is('san-pham/*')) {
            return redirect('/')->with('error', 'Sản phẩm không tồn tại hoặc đã bị xóa.');
        }

        // Trường hợp khác thì vẫn hiển thị 404
        return response()->view('errors.404', [], 404);
    }

    return parent::render($request, $exception);
}
}
