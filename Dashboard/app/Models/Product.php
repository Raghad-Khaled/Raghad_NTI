<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_en',
        'name_ar',
        'price',
        'quantity',
        'code',
        'status',
        'brand_id',
        'subcategory_id',
        'details_en',
        'details_ar',
        'image'
    ];
}
