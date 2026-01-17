<?php

namespace App\Notifications;

use App\Models\AdoptRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdoptionRequestReceived extends Notification
{
    use Queueable;

    public function __construct(public AdoptRequest $adoptRequest)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'adopt_request_id' => $this->adoptRequest->id,
            'animal_id' => $this->adoptRequest->animal_id,
            'animal_name' => $this->adoptRequest->animal->name,
            'requester_name' => $this->adoptRequest->user->name,
            'message' => $this->adoptRequest->message,
            'animal_url' => route('animals.show', $this->adoptRequest->animal),
        ];
    }
}
