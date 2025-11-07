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
        Schema::create('responders', function (Blueprint $table) {
             $table->id();
            $table->string('res_fname');
            $table->string('res_mname');
            $table->string('res_lname');
            $table->string('res_suffix')->nullable();
            $table->string('res_username')->unique();
            $table->string('res_email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('res_password');
            $table->string('res_contact')->unique();
            $table->string('res_position');
            $table->string('res_company');
            $table->string('res_workadd');
            $table->string('res_image')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responders');
    }
};
