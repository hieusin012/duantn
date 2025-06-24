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
        Schema::create('comments', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id');        // Người gửi bình luận
    $table->unsignedBigInteger('product_id');        // Bài viết/sản phẩm được bình luận
    $table->text('content');
    $table->timestamps();

    // Foreign keys (nếu có bảng users và posts)
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
