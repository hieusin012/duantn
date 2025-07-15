<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'email', 'address', 'status'];

    public function orders()
    {
        return $this->hasMany(Order::class, 'shipper_id');
    }
}
