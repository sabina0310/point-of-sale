<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 't_purchase';
    protected $fillable = [
        'name'
    ];

    public $timestamps = true;
}
