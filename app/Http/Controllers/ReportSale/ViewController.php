<?php

namespace App\Http\Controllers\ReportSale;

use App\Exports\SaleReportExcel;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ViewController extends Controller
{
    public function index()
    {
        return view('pages.report-sale.index');
    }

    public function filter(Request $request)
    {
        $filter = $request->all();
        $data['listSaleReport'] = Sale::with('SaleDetailsWithProduct')->where('status', 'success')
            ->when(!empty($filter['startDate']) || !empty($filter['endDate']), function ($query) use ($filter) {
                if (!empty($filter['startDate']) && !empty($filter['endDate'])) {
                    return $query->whereDate('updated_at', '>=', $filter['startDate'])
                        ->whereDate('updated_at', '<=', $filter['endDate']);
                } elseif (!empty($filter['startDate'])) {
                    return $query->whereDate('updated_at', '>=', $filter['startDate']);
                } elseif (!empty($filter['endDate'])) {
                    return $query->whereDate('updated_at', '<=', $filter['endDate']);
                }
                return $query;
            })
            ->orderBy('id', 'desc')
            ->get();

        if ($request->ajax()) {
            return view('pages.report-sale.partials.tableListSaleReport', $data);
        }

        return response()->json(['data' => $data]);
    }

    public function exportExcel(Request $request)
    {
        $filter['startDate'] = $request->startDate;
        $filter['endDate'] = $request->endDate;

        return Excel::download(new SaleReportExcel($filter), 'laporan-penjualan.xlsx');
    }
}
