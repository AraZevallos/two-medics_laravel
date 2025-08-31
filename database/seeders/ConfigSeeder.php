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
        DB::table('client_configurations')->insert([
            'tiktok' => 'https://tiktok.com',
            'whatsapp' => 'https://wa.me/123456789',
            'telegram' => 'https://t.me/username',
            'correo' => 'correo@ejemplo.com',

            'question' => '¿Cuál es tu problema?',
            'answer' => 'Mi problema es...',
            'explanation' => 'Explicación de la solución',

            'image_path' => '',
            'image_name' => '',
            'image_visible' => true,
        ]);
    }
}
