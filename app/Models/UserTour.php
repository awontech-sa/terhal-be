<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTour extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'user_id',
        'ut_comment', // User comment on the tour
        'ut_rate', // User rate on the tour
        'is_favorite', // Is the tour favorite
        'is_added', // Is the tour added
        'ut_status' // User status on the tour
    ];

    // Belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Belongs to Tour
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
