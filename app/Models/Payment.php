<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
    'order_code',
    'transaction_no',
    'bank_code',
    'card_type',
    'amount',
    'pay_date',
    'response_code',
    'transaction_status',
];

}
