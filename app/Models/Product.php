<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'm_product';
    protected $fillable = [
        'name',
        'category_id',
        'purchase_unit',
        'purchase_price',
        'quantity_per_purchase_unit',
        'price_per_purchase_item',
        'selling_unit',
        'selling_price',
        'stock'
    ];

    public $timestamps = true;
}
