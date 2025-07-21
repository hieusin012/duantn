<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = ['order_id', 'variant_id'];
    public $incrementing = false;

    protected $fillable = [
        'order_id', 'variant_id','product_name','color', 'size','product_image', 'price', 'quantity', 'total_price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }


}