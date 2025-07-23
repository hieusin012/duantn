<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("ALTER TABLE orders MODIFY payment_status ENUM('Chưa thanh toán', 'Đã thanh toán', 'Đã hoàn tiền')");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Nếu cần rollback, quay về trạng thái ban đầu
        DB::statement("ALTER TABLE orders MODIFY payment_status ENUM('Chưa thanh toán', 'Đã thanh toán')");
    }
};
