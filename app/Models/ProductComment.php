<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    protected $table = 'product_comments'; // nếu bảng tên vậy
    protected $fillable = ['product_id','user_id','content','parent_id','status'];
    protected $casts = [
        'status' => 'integer',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function replies()
    {
        return $this->hasMany(ProductComment::class, 'parent_id')->with('user', 'replies');
    }
}

