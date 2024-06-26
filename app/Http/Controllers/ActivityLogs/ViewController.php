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
        $data['listActivityLogs'] = ActivityLogs::with('user')->paginate(10);

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
