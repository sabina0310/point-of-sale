<?php

namespace App\Http\Controllers\Product;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\ProductExcel;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ViewController extends Controller
{
    public function index()
    {
        $data['totalProduct'] = Product::count();
        $data['outOfStockProduct'] = Product::where('stock', '<', 3)->count();

        // $data['listProduct'] = Product::join('m_category', 'm_product.category_id', 'm_category.id')->select('m_product.*', 'm_category.name as category_name')->orderByDesc('m_product.id')->paginate(2);
        return view('pages.product.index', $data);
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
            ->paginate(10);

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

    public function detail($id)
    {
        $data = Product::where('m_product.id', $id)
            ->join('m_category', 'm_product.category_id', '=', 'm_category.id')
            ->select('m_product.*', 'm_category.name as category_name')
            ->first();

        return view('pages.product.detailProduct', $data);
    }

    public function checkStock(Request $request)
    {
        $data = Product::where('stock', '<', 3)->get();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'data' => $data]);
        }
        return view('pages.product.partials.modalStock', $data);
    }

    public function exportFormatProduct()
    {
        $categories = Category::all();
        return Excel::download(new ProductExcel($categories), 'format-export-product.xlsx');
    }
}
