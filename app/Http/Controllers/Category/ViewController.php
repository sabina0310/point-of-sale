<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index()
    {
        return view('pages.category.index');
    }

    public function filter(Request $request)
    {
        $filter = $request->all();
        $data['listCategory'] = Category::when(!empty($filter['search']), function ($query) use ($filter) {
            return $query->where('name', 'like', '%' . $filter['search'] . '%');
        })->paginate(2);

        if ($request->ajax()) {
            return view('pages.category.partials.tableListCategory', $data);
        }

        return view('pages.category.index', $data);
    }
}
