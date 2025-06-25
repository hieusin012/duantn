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
        Schema::table('carts', function (Blueprint $table) {
            $table->foreignId('voucher_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['voucher_id']);
            $table->dropColumn('voucher_id');
        });
    }
};
