<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'role' => 2,
            'password' => Hash::make('12345678'),
        ]);

        // Create five staff users
        User::factory(5)->create([
            'role' => 1,
            'password' => Hash::make('12345678'),
        ]);
    }
}
