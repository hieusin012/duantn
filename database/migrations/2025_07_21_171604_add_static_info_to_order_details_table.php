<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->string('product_name')->after('variant_id');
            $table->string('color')->after('product_name');
            $table->string('size')->after('color');
            $table->string('product_image')->nullable()->after('size');
        });
    }

    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn(['product_name', 'color', 'size', 'product_image']);
        });
    }
};
