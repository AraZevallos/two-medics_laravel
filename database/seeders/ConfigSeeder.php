<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('configs')->insert([
            'tiktok' => 'https://tiktok.com',
            'whatsapp' => 'https://wa.me/123456789',
            'telegram' => 'https://t.me/username',
            'correo' => 'correo@ejemplo.com',
            'facebook' => 'https://facebook.com/usuario',
            'groups' => true,
            'flashcards' => true,
            'question' => 'Pregunta ejemplo',
            'answer' => 'Respuesta ejemplo',
            'url' => 'https://example.com',
        ]);
    }
}
