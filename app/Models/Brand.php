<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'brands';

    protected $fillable = ['name', 'logo'];

    // public $timestamps = false;
    
    protected $dates = ['deleted_at'];
}
