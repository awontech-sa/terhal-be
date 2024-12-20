<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'place_type_id', // Place Type
        'p_name', // Place Name
        'p_lang', // Place Longitude
        'p_lat' // Place Latitude
    ];

    // Many-to-Many relationship with Tours (for places that are part of a tour)
    public function tours()
    {
        return $this->belongsToMany(Tour::class, 'tour_places');
    }

    // Many-to-One relationship with PlaceType
    public function placeType()
    {
        return $this->belongsTo(PlaceType::class);
    }

}
