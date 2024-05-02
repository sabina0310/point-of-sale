<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Product;
use App\Models\Category;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{
    public function index()
    {
        $data['listPurchase'] = Purchase::join('m_product', 'm_product.id', 't_purchase.product_id')->select('t_purchase.*', 'm_product.name as product_name')->paginate(2);
        return view('pages.purchase.index', $data);
    }

    public function form($id = null)
    {
        $data['product'] = Product::all();
        $data['purchase'] = Purchase::where('id', $id)->first();

        return view('pages.purchase.form', $data);
    }
}
