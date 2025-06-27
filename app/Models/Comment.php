<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
   protected $fillable = [
    'user_id',
    'product_id',
    'content',
    'rating',
    'status'
];

    // Add this cast to ensure 'rating' is always treated as an integer
    protected $casts = [
        'rating' => 'integer',
        'status' => 'boolean', // It's good practice to cast booleans as well
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}