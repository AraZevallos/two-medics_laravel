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
        $emails = config('custom.admin_emails');
        foreach ($emails as $email) {
            User::factory()->create([
                'name' => 'Super Admin',
                'email' => $email,
                'password' => bcrypt('12345'),
            ]);
        }
    }
}
