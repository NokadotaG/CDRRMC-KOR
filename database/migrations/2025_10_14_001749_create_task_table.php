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
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('location');
            $table->enum('status', ['pending','ongoing','completed'])->default('pending');
            $table->unsignedBigInteger('responder_id');
            $table->foreign('responder_id')->references('id')->on('responders')->onDelete('cascade');
            $table->dateTime('due_datetime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};
