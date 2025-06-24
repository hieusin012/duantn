<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('comments', function (Blueprint $table) {
        $table->tinyInteger('rating')->nullable()->after('content'); // từ 1–5 sao
        $table->boolean('status')->default(1)->after('rating'); // 1 = hiện, 0 = ẩn
    });
}

public function down()
{
    Schema::table('comments', function (Blueprint $table) {
        $table->dropColumn(['rating', 'status']);
    });
}

};
