<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'pr_name', // Product name
        'pr_images', // Product images
        'pr_videos', // Product videos
        'pr_price', // Product price
        'pr_rates', // Product rates
        'pr_description', // Product description
        'user_id', // User the owner of the product
        'product_type_id' // Product type ID
    ];

    // Belongs to ProductType
    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    // Belongs to User (seller)
    public function user()
    {
        return $this->belongsTo(User::class); // The user who added the product
    }

    // Many-to-Many relationship with Users (buyers)
    public function buyers()
    {
        return $this->belongsToMany(User::class, 'user_products')
                    ->withPivot('up_comment', 'up_rate', 'is_favorite', 'is_buy', 'up_status');
    }

}
