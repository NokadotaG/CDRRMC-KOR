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
        Schema::create('sensor', function (Blueprint $table) {
            $table->id();
            $table->string("sensor_name")->unique();
            $table->string("sensor_type");
            $table->string("sensor_location");
            $table->string("sensor_status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor');
    }
};
