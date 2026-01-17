<?php
namespace App\Services;

use App\Models\AdoptionRequest;
use App\Models\Animal;
use App\Notifications\AdoptionRequestReceived;

class AdoptionService
{
    public function createRequest(Animal $animal, array $data)
    {
        // make request
        $request = AdoptionRequest::create([
            'animal_id' => $animal->id,
            'user_id' => auth()->id(),
            'message' => $data['message']
        ]);

        // notify owner
        $owner = $animal->user;
        $owner->notify(new AdoptionRequestReceived($request));

        return $request;
    }
}