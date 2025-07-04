<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code', 'name', 'slug', 'image', 'price', 'description',
        'status', 'is_active', 'views', 'category_id', 'brand_id'
    ];

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class, 'product_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function comments()
    {
    return $this->hasMany(Comment::class);
    }


}