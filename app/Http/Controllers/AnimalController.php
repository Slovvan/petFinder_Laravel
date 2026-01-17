<?php
namespace App\Http\Controllers;

use App\Repositories\AnimalRepository;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function __construct(protected AnimalRepository $animalRepo) {}

    public function index(Request $request)
    {
        // take all the filters
        $animals = $this->animalRepo->searchAnimals($request->only([
            'search', 'species', 'status', 'city'
        ]));
        
        return view('animals.index', compact('animals'));
    }
    public function myAnimals()
    {
        $animals = auth()->user()->animals()->latest()->get();
        return view('animals.my-animals', compact('animals'));
    }

    public function show(Animal $animal)
    {
        return view('animals.show', compact('animal'));
    }

    public function create()
    {
        return view('animals.create');
    }

    public function indexMap(Request $request)
    {
        $animals = $this->animalRepo->searchAnimals($request->only([
            'search', 'species', 'status', 'city'
        ]));

        // get animals with locations
        $locations = $animals->whereNotNull('latitude')->whereNotNull('longitude');

        return view('animals.index', compact('animals', 'locations'));
    }
}