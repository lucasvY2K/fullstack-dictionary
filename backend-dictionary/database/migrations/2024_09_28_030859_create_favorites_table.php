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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->bigInteger('word_id');
            $table->dateTime('added');

            $table->unique(['user_id', 'word_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->foreign('word_id')->references('id')->on('words')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
