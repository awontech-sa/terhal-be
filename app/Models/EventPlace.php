<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPlace extends Model
{
    use HasFactory;

    protected $fillable = [
        'place_id',
        'event_id'
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
