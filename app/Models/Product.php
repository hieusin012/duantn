<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'slug',
        'image',
        'price',
        'description',
        'status',
        'is_active',
        'views',
        'category_id',
        'brand_id',
        'is_hot_deal',
        'discount_percent',
        'deal_start_at',
        'deal_end_at'
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
    public function getAverageRatingAttribute()
    {
        $approvedComments = $this->comments()->where('status', 1);
        if ($approvedComments->count() > 0) {
            return round($approvedComments->avg('rating'), 1);
        }
        return 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->comments()->where('status', 1)->count();
    }

    protected static function booted()
    {
        static::deleting(function ($product) {
            CartItem::where('product_id', $product->id)->delete();
        });
    }

    protected $casts = [
        'sale_start_date' => 'datetime',
        'sale_end_date' => 'datetime',
        'deal_start_at' => 'datetime',
        'deal_end_at' => 'datetime',
    ];
    public function orderDetails()
    {
        return $this->hasManyThrough(
            \App\Models\OrderDetail::class,      // Model cuối: OrderDetail
            \App\Models\ProductVariant::class,   // Model trung gian: ProductVariant
            'product_id',                        // FK trong ProductVariant trỏ đến Product
            'variant_id',                        // FK trong OrderDetail trỏ đến ProductVariant
            'id',                                // PK của Product
            'id'                                 // PK của ProductVariant
        );
    }

}
