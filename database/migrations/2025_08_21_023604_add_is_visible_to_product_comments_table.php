<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('product_comments', function (Blueprint $table) {
            $table->boolean('is_visible')->default(true)->after('content');
            $table->index(['product_id', 'is_visible']);
        });
    }

    public function down(): void
    {
         Schema::table('product_comments', function (Blueprint $table) {
        $table->dropIndex('product_comments_product_id_is_visible_index'); // <- dùng tên index
        $table->dropColumn('is_visible');
    });
    }
};
