<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // usuarios de prueba
        User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'test',
        ]);

        $userAdmin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'test',
        ]);
    }
}
