<?php

namespace App\Services;
use App\Repositories\AnimalRepository;

class AnimalService {
    protected $repository;

    public function __construct(AnimalRepository $repository) {
        $this->repository = $repository;
    }

    public function storeAnimal(array $data) {
        return auth()->user()->animals()->create($data);
    }
    
    public function archiveExpiredPosts()
    {
        return $this->repository->archiveOldAnimals();
    }
}