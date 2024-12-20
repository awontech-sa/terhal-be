<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'ue_comment', // User comment on event
        'ue_rate', // User rate on event
        'is_favorite' // Is event favorite for user
    ];

    // Belongs to User (participant)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Belongs to Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
