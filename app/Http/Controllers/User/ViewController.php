<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index()
    {
        return view('pages.user.index');
    }

    public function filter(Request $request)
    {
        $filter = $request->all();
        $data['listUser'] = User::when(!empty($filter['search']), function ($query) use ($filter) {
            return $query->where('name', 'like', '%' . $filter['search'] . '%');
        })->paginate(10);

        if ($request->ajax()) {
            return view('pages.user.partials.tableListUser', $data);
        }

        return view('pages.user.index', $data);
    }

    public function form($id = null)
    {
        $data['user'] = User::where('id', $id)->first();

        return view('pages.user.form', $data);
    }
}
