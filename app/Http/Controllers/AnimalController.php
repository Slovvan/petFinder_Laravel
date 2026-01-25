<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Services\AnimalService;
use App\Http\Requests\AnimalStoreRequest;
use App\Http\Requests\AnimalUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{
    public function __construct(protected AnimalService $animalService) {}

    public function index(Request $request)
    {
        $animals = $this->animalService->searchAnimals($request->only([
            'search', 'species', 'status', 'city',
        ]));

        // Pass items collection for map markers iteration
        $animalsForMap = $animals->getCollection();

        return view('animals.index', compact('animals', 'animalsForMap'));
    }

    public function myAnimals()
    {
        $animals = $this->animalService->listUserAnimals(auth()->user());

        return view('animals.my-animals-blade', compact('animals'));
    }

    public function show(Animal $animal)
    {
        return view('animals.show', compact('animal'));
    }

    public function create()
    {
        return view('animals.create');
    }

    public function store(AnimalStoreRequest $request)
    {
        $this->authorize('create', Animal::class);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('animals', 'public');
        }

        $this->animalService->storeAnimal($validated);

        return redirect()->route('animals.mine')->with('success', '¡Anuncio publicado exitosamente!');
    }

    public function edit(Animal $animal)
    {
        $this->authorize('update', $animal);

        return view('animals.edit', compact('animal'));
    }

    public function update(AnimalUpdateRequest $request, Animal $animal)
    {
        $this->authorize('update', $animal);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($animal->image) {
                Storage::disk('public')->delete($animal->image);
            }

            $validated['image'] = $request->file('image')->store('animals', 'public');
        }

        $animal->update($validated);

        return redirect()->route('animals.mine')->with('success', 'Anuncio actualizado exitosamente.');
    }

    public function destroy(Animal $animal)
    {
        $this->authorize('delete', $animal);

        if ($animal->image) {
            Storage::disk('public')->delete($animal->image);
        }

        $animal->delete();

        return redirect()->route('animals.mine')->with('success', 'Anuncio eliminado exitosamente.');
    }

    public function indexMap(Request $request)
    {
        $animals = $this->animalService->searchAnimals($request->only([
            'search', 'species', 'status', 'city',
        ]));

        $locations = $this->animalService->filterLocatedAnimals($animals);

        return view('animals.index', compact('animals', 'locations'));
    }

    public function notifications()
    {
        $notifications = auth()->user()->notifications()->paginate(10);

        return view('animals.notifications', compact('notifications'));
    }

    public function unreadNotificationsCount()
    {
        $count = auth()->user()->unreadNotifications()->count();

        return response()->json(['count' => $count]);
    }

    public function unreadNotifications()
    {
        $notifications = auth()->user()->unreadNotifications()
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'animal_name' => $notification->data['animal_name'] ?? 'Animal',
                    'requester_name' => $notification->data['requester_name'] ?? 'Utilisateur',
                    'message' => $notification->data['message'] ?? 'Sans message',
                    'animal_url' => $notification->data['animal_url'] ?? '#',
                    'created_at' => $notification->created_at->diffForHumans(),
                ];
            });

        return response()->json(['notifications' => $notifications]);
    }
}