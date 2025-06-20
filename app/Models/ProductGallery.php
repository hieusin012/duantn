<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGallery extends Model
{
    use SoftDeletes;

    protected $fillable = ['image', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

