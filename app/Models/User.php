<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, HasRoles;

    protected $fillable = [
        'user_type_id',
        'name',
        'email',
        'phone',
        'password',
        'status',
        'age',
        'gender',
    ];

    // Many-to-One relationship with UserType
    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }

    // One-to-Many relationship with Events (for Event Organizers)
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    // One-to-Many relationship with Tours (for tour-guides)
    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    // One-to-Many relationship with Products (for Product Owners)
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Many-to-Many relationship with Events (attended events)
    public function attendedEvents()
    {
        return $this->belongsToMany(Event::class, 'user_events')
            ->withPivot('ue_comment', 'ue_rate', 'is_favorite');
    }

    // Many-to-Many relationship with Tours (joined tours)
    public function joinedTours()
    {
        return $this->belongsToMany(Tour::class, 'user_tours')
            ->withPivot('ut_comment', 'ut_rate', 'is_favorite', 'is_added', 'ut_status');
    }

    // Many-to-Many relationship with Products (purchased products)
    public function purchasedProducts()
    {
        return $this->belongsToMany(Product::class, 'user_products')
            ->withPivot('up_comment', 'up_rate', 'is_favorite', 'is_buy', 'up_status');
    }

    // One-to-Many relationship with Notifications (for received notifications)
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
