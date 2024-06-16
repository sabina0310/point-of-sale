<?php

namespace App\Http\Controllers\ReportSale;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index()
    {
        return view('pages.report-sale.index');
    }

    public function filter(Request $request)
    {
        $data['listSaleReport'] = Sale::with('SaleDetailsWithProduct')->where('status', 'success')->orderBy('id', 'desc')->get();

        if ($request->ajax()) {
            return view('pages.report-sale.partials.tableListSaleReport', $data);
        }

        return response()->json(['data' => $data]);
    }
}
