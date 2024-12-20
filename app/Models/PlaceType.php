<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceType extends Model
{
    use HasFactory;

    protected $fillable = ['pt_name'];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
