<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index()
    {
        $data['listCategory'] = Category::paginate(2);
        return view('pages.category.index', $data);
    }
}
