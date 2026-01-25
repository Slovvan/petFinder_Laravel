<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Animal;
use App\Models\AdoptRequest;
use App\Notifications\AdoptionRequestReceived;
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

        $animals = Animal::factory(100)->recycle($users)->create();

        for ($i = 0; $i < 100; $i++) {
            $animal = $animals->random();
            $requester = $users->where('id', '!=', $animal->user_id)->random();

            $adoptRequest = AdoptRequest::factory()->create([
                'animal_id' => $animal->id,
                'user_id' => $requester->id,
            ]);

            if ($animal->user) {
                $animal->user->notify(new AdoptionRequestReceived($adoptRequest));
            }
        }
    }
}
