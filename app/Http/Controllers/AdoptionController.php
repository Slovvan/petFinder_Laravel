<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdoptionController extends Controller
{
    public function store(Request $request, Animal $animal, AdoptionService $service)
    {
        $validated = $request->validate(['message' => 'required|string|max:500']);
        
        $service->createRequest($animal, $validated);
        
        return back()->with('success', 'Owner notified.');
    }
}
