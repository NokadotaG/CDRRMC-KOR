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
        Schema::create('civil', function (Blueprint $table) {
           $table->id();
            $table->string('username')->unique(); // Unique username
            $table->string('image')->nullable(); // Optional image path/URL
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('suffix')->nullable(); // Optional
            $table->date('birthday');
            $table->enum('gender', ['male', 'female', 'other']); // Adjust options as needed
            $table->string('street_purok'); // Street or Purok
            $table->string('baranggay'); // Baranggay
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('civil');
    }
};
