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
        Schema::create('client_configurations', function (Blueprint $table) {
            $table->id();

            // socials
            $table->string('tiktok', 255)->nullable();
            $table->string('whatsapp', 255)->nullable();
            $table->string('telegram', 255)->nullable();
            $table->string('correo', 255)->nullable();

            // dynamic questions
            $table->string('question', 175)->nullable();
            $table->string('answer', 52)->nullable();
            $table->string('explanation', 175)->nullable();

            // promocional
            $table->string('image_path', 255)->nullable();
            $table->string('image_name', 255)->nullable();
            $table->boolean('image_visible')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_configurations');
    }
};
