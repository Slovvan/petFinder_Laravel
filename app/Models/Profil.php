<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    protected $fillable = ['bio', 'profile_photo', 'user_id'];
}
