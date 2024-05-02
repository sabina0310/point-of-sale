<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index()
    {
        $data['listProduct'] = Product::join('m_category', 'm_product.category_id', 'm_category.id')->select('m_product.*', 'm_category.name as category_name')->orderByDesc('m_product.id')->paginate(2);
        return view('pages.product.index', $data);
    }

    public function form($id = null)
    {
        $data['category'] = Category::all();
        $data['product'] = Product::where('id', $id)->first();

        return view('pages.product.form', $data);
    }
}
