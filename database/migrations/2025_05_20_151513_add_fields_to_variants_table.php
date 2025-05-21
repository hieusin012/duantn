<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('variants', function (Blueprint $table) {
            $table->double('sale_price')->nullable()->after('price');
            $table->date('sale_date')->nullable()->after('sale_price');
            $table->string('image', 255)->after('quantity');
        });
    }

    public function down(): void {
        Schema::table('variants', function (Blueprint $table) {
            $table->dropColumn(['sale_price', 'sale_date', 'image']);
        });
    }
};
