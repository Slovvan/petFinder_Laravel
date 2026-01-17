<?php

namespace App\Repositories;

use App\Models\Animal;
use Illuminate\Pagination\LengthAwarePaginator;

class AnimalRepository
{
    public function getAllActive(): LengthAwarePaginator
    {
        return Animal::latest()->paginate(10);
    }

    public function findById(int $id): Animal
    {
        return Animal::findOrFail($id);
    }

    public function searchAnimals(array $filters): LengthAwarePaginator
    {
        // Full-text path: keep structured filters inside the Scout query callback
        if (!empty($filters['search'])) {
            return Animal::search($filters['search'])
                ->query(function ($builder) use ($filters) {
                    if (!empty($filters['species'])) {
                        $builder->where('species', $filters['species']);
                    }

                    if (!empty($filters['status'])) {
                        $builder->where('status', $filters['status']);
                    }

                    if (!empty($filters['city'])) {
                        $builder->where('city', 'LIKE', '%' . $filters['city'] . '%');
                    }

                    $builder->latest();
                })
                ->paginate(12);
        }

        // Structured filters only (no full-text)
        $query = Animal::query();

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

    public function archiveOldAnimals(): int
    {
        // animals created more than 30 days ago and not archived
        return Animal::where('created_at', '<', now()->subDays(30))
            ->where('status', '!=', 'Archived')
            ->update(['status' => 'Archived']);
    }
}