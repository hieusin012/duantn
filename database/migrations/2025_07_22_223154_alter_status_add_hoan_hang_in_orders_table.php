<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE orders MODIFY status ENUM(
            'Chờ xác nhận',
            'Đã xác nhận',
            'Đang chuẩn bị hàng',
            'Đang giao hàng',
            'Đã giao hàng',
            'Đơn hàng đã hủy',
            'Đã hoàn hàng' -- ✅ Thêm dòng này
        ) DEFAULT 'Chờ xác nhận'");
    }

    public function down(): void
    {
        // Nếu rollback thì bỏ 'Đã hoàn hàng'
        DB::statement("ALTER TABLE orders MODIFY status ENUM(
            'Chờ xác nhận',
            'Đã xác nhận',
            'Đang chuẩn bị hàng',
            'Đang giao hàng',
            'Đã giao hàng',
            'Đơn hàng đã hủy'
        ) DEFAULT 'Chờ xác nhận'");
    }
};
