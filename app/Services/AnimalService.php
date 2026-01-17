<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\AnimalRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AnimalService
{
    public function __construct(protected AnimalRepository $repository) {}

    public function storeAnimal(array $data)
    {
        return auth()->user()->animals()->create($data);
    }

    public function searchAnimals(array $filters): LengthAwarePaginator
    {
        return $this->repository->searchAnimals($filters);
    }

    public function listUserAnimals(User $user): Collection
    {
        return $user->animals()->latest()->get();
    }

    public function filterLocatedAnimals(LengthAwarePaginator $animals): Collection
    {
        return $animals->getCollection()->whereNotNull('latitude')->whereNotNull('longitude');
    }

    public function archiveExpiredPosts(): int
    {
        return $this->repository->archiveOldAnimals();
    }
}