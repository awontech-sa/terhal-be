<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPlace extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'place_id'
    ];

    // Many-to-Many relationship between Tours and Places
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
