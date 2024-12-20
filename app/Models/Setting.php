<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'about', // About Us
        'terms_conditions', // Terms & Conditions
        'policies' // Policies
    ];

    use HasFactory;
}
