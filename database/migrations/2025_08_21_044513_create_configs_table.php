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
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('tiktok', 255);
            $table->string('whatsapp', 255);
            $table->string('telegram', 255);
            $table->string('correo', 255);
            $table->string('facebook', 255);
            $table->boolean('groups')->default(true);
            $table->boolean('flashcards')->default(true);
            $table->string('question', 255);
            $table->string('answer', 255);
            $table->string('url', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configs');
    }
};
