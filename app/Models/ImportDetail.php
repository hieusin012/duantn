<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImportDetail extends Model
{
    use HasFactory;

    protected $fillable = ['import_id', 'product_id', 'quantity', 'price', 'total_price'];

    public function import() {
        return $this->belongsTo(Import::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}

