<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    // ➜ Thêm 'is_visible' để cho phép cập nhật Ẩn/Hiện
    protected $fillable = ['product_id', 'user_id', 'content', 'parent_id', 'is_visible'];

    // (Tuỳ chọn) ép kiểu boolean nếu muốn an toàn hơn
    protected $casts = [
        'is_visible' => 'boolean',
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

    // (Tuỳ chọn) scopes thuận tiện cho frontend nếu cần dùng
    public function scopeVisible($q) { return $q->where('is_visible', true); }
    public function scopeHidden($q)  { return $q->where('is_visible', false); }
}
