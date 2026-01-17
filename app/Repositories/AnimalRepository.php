<?php

namespace App\Repositories;
use App\Models\Animal;

class AnimalRepository {
    public function getAllActive() {
        return Animal::latest()->paginate(10);
    }

    public function findById($id) {
        return Animal::findOrFail($id);
    }

    public function searchAnimals($filters){
    $query = Animal::query();

        // search by word
        if (!empty($filters['search'])) {
            $query = Animal::search($filters['search'])->query(function ($builder) {
                
            });
        }

        // search by feature
        if (!empty($filters['species'])) {
            $query->where('species', $filters['species']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['city'])) {
            $query->where('city', 'LIKE', '%' . $filters['city'] . '%');
        }

        return $query->latest()->paginate(12);
    }
    public function archiveOldAnimals()
    {
        // animals created more than 30 days ago and not archived
        return Animal::where('created_at', '<', now()->subDays(30))
            ->where('status', '!=', 'Archived')
            ->update(['status' => 'Archived']);
    }
}