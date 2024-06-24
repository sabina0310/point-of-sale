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
        $filter = $request->all();
        $data['listSaleHistory'] = Sale::orderByDesc('id')
            ->when(!empty($filter['search']), function ($query) use ($filter) {
                return $query->where('t_sale.invoice_number', 'like', '%' . $filter['search'] . '%');
            })->paginate(5);
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
