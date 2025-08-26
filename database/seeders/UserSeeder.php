<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Araccelli Zevallos',
                'email' => 'araccelli.zevallos@gmail.com',
                'password' => bcrypt('12345'), // password
                'role' => 'super-admin',
                'guard' => 'web',
            ],
            [
                'name' => 'Frank Jacobo',
                'email' => 'frankejacobos@gmail.com',
                'password' => bcrypt('12345'), // password
                'role' => 'admin',
                'guard' => 'web',
            ],
            [
                'name' => 'Two Medics',
                'email' => 'twomedicspruebas@gmail.com',
                'password' => bcrypt('12345'), // password
                'role' => 'admin',
                'guard' => 'web',
            ],
        ];

        foreach ($users as $user) {
            User::factory()->create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'], // password
            ]);
        }
    }
}
