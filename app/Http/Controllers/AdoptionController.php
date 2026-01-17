<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AdoptRequest;
use App\Notifications\AdoptionRequestReceived;
use App\Http\Requests\AdoptionRequest as AdoptionFormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdoptionController extends Controller
{
    public function store(AdoptionFormRequest $request, Animal $animal): RedirectResponse
    {
        $this->authorize('adopt', $animal);

        $validated = $request->validated();

        // Crear la solicitud de adopción
        $adoptRequest = AdoptRequest::create([
            'animal_id' => $animal->id,
            'user_id' => auth()->id(),
            'message' => $validated['message'],
        ]);

        // Notificar al dueño del animal (solo si existe usuario asociado)
        if ($animal->user) {
            $animal->user->notify(new AdoptionRequestReceived($adoptRequest));
        }

        return redirect()->route('animals.show', $animal)
            ->with('success', '¡Solicitud de adopción enviada! El dueño del animal pronto se pondrá en contacto contigo.');
    }

    public function markAsRead($notificationId): RedirectResponse
    {
        $notification = auth()->user()->notifications()->find($notificationId);

        if ($notification) {
            $notification->update(['read_at' => now()]);
        }

        return back()->with('success', 'Notificación marcada como leída.');
    }
}
