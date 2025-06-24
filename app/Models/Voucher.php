<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'discount',
        'discount_type',
        'quantity',
        'max_price',
        'start_date',
        'end_date',
        'used',
        'is_active',
    ];
}
