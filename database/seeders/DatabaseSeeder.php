<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; 

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(22)->create();

        User::factory()->create([
            'username' => 'admin',
            'email' => 'dangcaoanh1998@gmail.com',
            'password' => Hash::make('1234A'), 
            'photo' => 'users/default-image.png',
            'role' => 'admin',
            'description' => 'This is a test user.',
          
        ]);
       
    }
}
