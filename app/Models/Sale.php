<?php

namespace App\Models;

use App\Observers\SaleObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([SaleObserver::class])]
class Sale extends Model
{
    use HasFactory;
    protected $table = 't_sale';

    public $timestamps = true;

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class, 'sale_id', 'id');
    }

    public function saleDetailsWithProduct()
    {
        return $this->saleDetails()->with('product');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id')
            ->select(['id', 'name']);;
    }
    
}
