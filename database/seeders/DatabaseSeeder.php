<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Animal;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $users = User::factory(50)->create()->each(function ($user) {
        $user->profile()->create(['bio' => 'New profil.']); 
        });

        // create 100 new animals
        Animal::factory(100)->recycle($users)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
