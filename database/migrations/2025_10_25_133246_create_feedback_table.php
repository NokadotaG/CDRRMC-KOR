<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            // Explicitly set the engine to InnoDB (required for foreign keys in MySQL)
            $table->engine = 'InnoDB';
            
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('responder_id');
            
            // Foreign keys (ensure 'tasks' and 'responders' tables exist and have matching 'id' columns)
            $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade');
            $table->foreign('responder_id')->references('id')->on('responders')->onDelete('cascade');
            
            $table->integer('rating');
            $table->text('comments');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }
};