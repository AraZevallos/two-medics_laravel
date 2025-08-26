<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parents = [
            ['name' => 'Exámenes', 'icon' => 'filepenline'],
            ['name' => 'Cursos', 'icon' => 'rocket'],
            ['name' => 'Preguntas', 'icon' => 'messagecirclequestion'],
            ['name' => 'Difusión', 'icon' => 'megaphone'],
            ['name' => 'Videoclases', 'icon' => 'squareplay'],
        ];

        $children = [
            ['name' => 'Ciencia de la salud'],
            ['name' => 'Medicina de la salud'],
            ['name' => 'Medicina del tratamiento de enfermedades infecciosas'],
            ['name' => 'Farmacia'],
            ['name' => 'Nutrición'],
        ];

        foreach ($parents as $parent) {
            // Insert parent
            $parentId = DB::table('courses')->insertGetId([
                'name' => $parent['name'],
                'icon' => $parent['icon'],
            ]);

            // Insert persistent code for parent
            DB::table('codes')->insert([
                'course_id' => $parentId,
                'is_enabled' => true,
                'is_persistent' => true,
                'expiration_date' => null,
                'value' => Str::upper(Str::random(6)) . date('y'),
            ]);

            // Insert children
            foreach ($children as $child) {
                $childId = DB::table('courses')->insertGetId([
                    'name' => $child['name'],
                    'parent_id' => $parentId,
                ]);

                // Insert 1 persistent code for child
                DB::table('codes')->insert([
                    'course_id' => $childId,
                    'is_enabled' => true,
                    'is_persistent' => true,
                    'expiration_date' => null,
                    'value' => Str::upper(Str::random(6)) . date('y'),
                ]);

                // Insert 2 non-persistent codes for child
                for ($i = 0; $i < 2; $i++) {
                    DB::table('codes')->insert([
                        'course_id' => $childId,
                        'is_enabled' => true,
                        'is_persistent' => false,
                        'expiration_date' => null,
                        'value' => Str::upper(Str::random(6)) . date('y'),
                    ]);
                }
            }
        }
    }
}
