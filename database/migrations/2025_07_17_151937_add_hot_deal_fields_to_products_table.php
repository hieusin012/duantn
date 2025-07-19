<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_hot_deal')->default(false);
            $table->unsignedInteger('discount_percent')->nullable();
            $table->dateTime('deal_end_at')->nullable();
        });
    }

    public function down(): void {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_hot_deal', 'discount_percent', 'deal_end_at']);
        });
    }
};
