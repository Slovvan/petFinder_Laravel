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
}