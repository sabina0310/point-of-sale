<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $table = 'm_product';
    protected $fillable = [
        'name',
        'category_id',
        'purchase_unit',
        'purchase_price',
        'quantity_per_purchase_unit',
        'price_per_purchase_item',
        'sale_unit',
        'sale_price',
        'stock'
    ];

    public $timestamps = true;
}
