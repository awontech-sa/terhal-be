<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id', // User who added the product
        'up_comment', // User comment on the product
        'up_rate', // User rate on the product
        'is_favorite', // Is the product favorite
        'is_buy', // Is the product bought
        'up_status' // User status on the product
    ];

    // Many-to-Many relationship between Users and Products
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Many-to-Many relationship between Products and Users
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
