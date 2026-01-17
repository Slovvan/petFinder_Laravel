<?php

namespace App\Policies;

use App\Models\Animal;
use App\Models\User;

class AnimalPolicy
{
    /**
     * Determine if the user can view the animal.
     */
    public function view(?User $user, Animal $animal): bool
    {
        // Cualquiera puede ver animales (incluso sin autenticar)
        return true;
    }

    /**
     * Determine if the user can create animals.
     */
    public function create(User $user): bool
    {
        // Solo usuarios autenticados pueden crear
        return true;
    }

    /**
     * Determine if the user can update the animal.
     */
    public function update(User $user, Animal $animal): bool
    {
        // Solo el propietario puede editar
        return $user->id === $animal->user_id;
    }

    /**
     * Determine if the user can delete the animal.
     */
    public function delete(User $user, Animal $animal): bool
    {
        // Solo el propietario puede eliminar
        return $user->id === $animal->user_id;
    }

    /**
     * Determine if the user can adopt the animal (send adoption request).
     */
    public function adopt(User $user, Animal $animal): bool
    {
        // No puedes adoptar tu propio animal
        return $user->id !== $animal->user_id;
    }
}
