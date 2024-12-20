<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'n_title', // Notification Title
        'n_message', // Notification Message
        'n_type', // Notification Type
        'is_read', // Is Read
        'role_target', // Role Target
        'user_id', // User ID (Who will receive the notification)
    ];

    // Many-to-One relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
