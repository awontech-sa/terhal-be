<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // User ID (creator of the tour)
        't_name', // Tour name
        't_image', // Tour image
        't_rate', // Tour rate
        't_date', // Tour date
        't_description', // Tour description
        't_price', // Tour price
        't_videos',
        't_duration',
        'visitor_limit'
    ];

    // Belongs to User (creator of the tour)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Many-to-Many relationship with Users (participants)
    public function participants()
    {
        return $this->belongsToMany(User::class, 'user_tours')
                    ->withPivot('ut_comment', 'ut_rate', 'is_favorite', 'is_added', 'ut_status');
    }

}
