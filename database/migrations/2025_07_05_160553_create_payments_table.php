<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_code');
            $table->string('transaction_no')->nullable(); // Mã giao dịch VNPay
            $table->string('bank_code')->nullable();      // Mã ngân hàng
            $table->string('card_type')->nullable();      // Loại thẻ
            $table->bigInteger('amount');                 // Số tiền (VND)
            $table->string('pay_date')->nullable();       // Ngày thanh toán (YYYYMMDDHHMMSS)
            $table->string('response_code')->nullable();  // Mã phản hồi
            $table->string('transaction_status')->nullable(); // Trạng thái
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
