<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
    public function isExpired()
{
    if (!$this->end_date) {
        return false; // Nếu chưa đặt ngày kết thúc thì coi như chưa hết hạn
    }

    return now()->gt(Carbon::parse($this->end_date));
}
    public function isValid()
    {
        return !$this->isExpired() && $this->is_active && $this->quantity > 0;
    }
}
