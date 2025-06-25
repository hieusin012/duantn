<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
    public function applyVoucher(Voucher $voucher)
    {
        $this->voucher_id = $voucher->id;
        $this->save();
    }
}
