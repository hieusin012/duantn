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
        Schema::create('order_details', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained();
            $table->foreignId('variant_id')->constrained('product_variants');
            $table->double('price', 10, 2);
            $table->integer('quantity');
            $table->double('total_price', 10, 2);
            $table->primary(['order_id','variant_id']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
