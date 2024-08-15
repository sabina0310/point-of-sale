<?php

namespace App\Http\Controllers\ActivityLogs;

use App\Http\Controllers\Controller;
use App\Models\ActivityLogs;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index()
    {
        return view('pages.activityLogs.index');
    }

    public function filter(Request $request)
    {
        $filter = $request->all();
        $data['listActivityLogs'] = ActivityLogs::with('user')->when(!empty($filter['search']), function ($query) use ($filter) {
            return $query->where('model', $filter['search']);
        })->orderBy('id', 'desc')->paginate(20);

        if ($request->ajax()) {
            return view('pages.activityLogs.partials.tableListActivityLogs', $data);
        }
    }

    public function detail($id = null)
    {
        $data['data'] = ActivityLogs::where('id', $id)->with('user')->first();
        // $data['detail'] = json_decode($data['data']->data);
        // dd($data['detail']);

        return view('pages.activityLogs.detailActivityLogs', $data);
    }
}
