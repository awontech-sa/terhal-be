<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    // One-to-Many relationship with Users
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
