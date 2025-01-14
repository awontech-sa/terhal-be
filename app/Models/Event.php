<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'e_name', // Event name
        'e_images', // Event images
        'e_location', // Event location
        'e_price', // Event price
        'e_description', // Event description
        'e_date', // Event date
        'e_rate', // Event rate
        'e_videos', // Event videos
        'user_id', // User ID (creator of the event)
        'event_type_id',
        'e_lang',
        'e_lat' // Event Type ID
    ];

    // Belongs to User (creator of the event)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    // Many-to-Many relationship with Users (attendees)
    public function attendees()
    {
        return $this->belongsToMany(User::class, 'user_events')
            ->withPivot('ue_comment', 'ue_rate', 'is_favorite');
    }

    public function getEImagesAttribute()
    {
        $baseUrl = config('filesystems.disks.do.url');
        $images = json_decode($this->attributes['e_images'], true);

        if (is_array($images)) {
            $formattedImages = array_map(function ($image) use ($baseUrl) {
                return $baseUrl . '/' . $image;
            }, $images);

            return $formattedImages;
        }

        return [];
    }

    public function getEVideosAttribute()
    {
        return config('filesystems.disks.do.url') . '/' . $this->attributes['e_videos'];
    }
}
