<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code', 'fullname', 'phone', 'address', 'email', 'payment',
        'status', 'payment_status', 'shiping', 'discount',
        'total_price', 'note', 'user_id', 'voucher_id' // THÊM 'voucher_id' VÀO FILLABLE
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}