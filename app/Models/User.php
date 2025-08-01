<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'fullname', 'avatar', 'phone', 'address', 'email', 'password', 'role', 'status', 'otp',
        'google_id', 'facebook_id', 'gender', 'birthday', 'language', 'introduction'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'date',
    ];
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function blogs()
{
    return $this->hasMany(\App\Models\Blog::class, 'user_id');
}
public function setPhoneAttribute($value)
{

    $value = preg_replace('/[^0-9+]/', '', $value);
    $value = preg_replace('/^\+84/', '0', $value);
    $this->attributes['phone'] = $value;
}
    public function orders()
    {
        return $this->hasMany(Order::class);
    }


}
