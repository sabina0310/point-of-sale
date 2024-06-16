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
        // $data['listProduct'] = Product::join('m_category', 'm_product.category_id', 'm_category.id')->select('m_product.*', 'm_category.name as category_name')->orderByDesc('m_product.id')->paginate(2);
        return view('pages.product.index');
    }

    public function filter(Request $request)
    {
        $filter = $request->all();
        $data['listProduct'] = Product::join('m_category', 'm_product.category_id', 'm_category.id')
            ->select('m_product.*', 'm_category.name as category_name')
            ->when(!empty($filter['search']), function ($query) use ($filter) {
                return $query->where('m_product.name', 'like', '%' . $filter['search'] . '%');
            })
            ->orderByDesc('m_product.id')
            ->paginate(5);

        if ($request->ajax()) {
            return view('pages.product.partials.tableListProduct', $data);
        }

        return view('pages.product.index', $data);
    }

    public function form($id = null)
    {
        $data['category'] = Category::all();
        $data['product'] = Product::where('id', $id)->first();

        return view('pages.product.form', $data);
    }
}
