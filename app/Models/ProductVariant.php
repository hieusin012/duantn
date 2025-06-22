<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'product_variants';
    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'price',
        'sale_price',
        'quantity',
        'images'
    ];
    public $timestamps = false;
    protected $dates = ['deleted_at'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
        public function totalSold()
    {
        return $this->OrderDetail()->sum('quantity');
    }
    public function galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }

}
