<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('product_comments', function (Blueprint $table) {
            $table->unsignedTinyInteger('status')
                  ->default(0)
                  ->after('parent_id'); // 0 = Ẩn, 1 = Hiển
        });
    }

    public function down(): void {
        Schema::table('product_comments', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
