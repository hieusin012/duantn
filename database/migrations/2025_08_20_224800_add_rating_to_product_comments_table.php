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
    Schema::table('product_comments', function (Blueprint $table) {
        $table->unsignedTinyInteger('rating')->default(0)->after('content'); 
        // rating: giá trị từ 1 đến 5 (ví dụ cho đánh giá sao)
    });
}

public function down(): void
{
    Schema::table('product_comments', function (Blueprint $table) {
        $table->dropColumn('rating');
    });
}

};
