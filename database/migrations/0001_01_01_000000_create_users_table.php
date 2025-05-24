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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 199);
            $table->string('avatar', 255)->nullable();
            $table->string('phone', 11)->nullable();
            $table->string('address')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role',['member','admin'])->default('member');
            $table->boolean('status')->default(true);
            $table->string('otp')->nullable();
            $table->string('google_id')->nullable()->unique();
            $table->enum('gender', ['Nam', 'Nữ', 'Khác'])->nullable();
            $table->date('birthday')->nullable();
            $table->string('language')->nullable()->default('Vietnamese');
            $table->text('introduction')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
