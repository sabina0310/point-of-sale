<?php

namespace App\Http\Controllers\SaleHistory;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index()
    {
        return view('pages.selling-history.index');
    }

    public function filter(Request $request)
    {
        $data['listSaleHistory'] = Sale::orderByDesc('id')->paginate(5);
        if ($request->ajax()) {
            return view('pages.selling-history.partials.tableListSellingHistory', $data);
        }
        return view('pages.selling-history.index', $data);
    }

    public function form(Request $request)
    {

        $sale = Sale::find($request->id);
        $data['invoice_number'] = $sale->invoice_number;

        return view('pages.selling.index', $data);
    }
}
