<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable; 

class Animal extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['name', 'species', 'status', 'city', 'description', 'user_id', 'latitude', 'longitude', 'image'];

    // Ddata to index
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'species' => $this->species,
            'city' => $this->city,
            'description' => $this->description,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}