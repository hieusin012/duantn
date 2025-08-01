<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model

{
    use SoftDeletes;

    protected $fillable = ['name', 'value'];

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }

}

