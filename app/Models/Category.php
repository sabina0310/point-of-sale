<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $table = 'm_category';
    protected $fillable = [
        'id',
        'category_code',
        'name',
    ];
    // protected $visible = ['id', 'name'];

    public $timestamps = true;
}
