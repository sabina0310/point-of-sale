<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $filter = $request->all();
        $data['todaysTransaction'] = Sale::where('status', 'success')->whereDate('updated_at', Carbon::today())->count();
        $data['todaysSale'] = Sale::where('status', 'success')->whereDate('updated_at', Carbon::today())->sum('total_price');
        $data['todaysProfit'] = Sale::where('status', 'success')->whereDate('updated_at', Carbon::today())->sum('total_profit');

        return view('pages.dashboard', $data);
    }

    public function chartTransaction(Request $request)
    {
        $filter = $request->all();
        $data = Sale::select([
            DB::raw('CONCAT(monthname(updated_at), " ", year(updated_at)) as date'),
            DB::raw('COUNT(t_sale.id) as total_transaction')
        ])->when(!empty($filter['startDate']) && !empty($filter['endDate']), function ($query) use ($filter) {
            return $query->where(DB::raw('DATE_FORMAT(updated_at, "%Y-%m")'), '>=', $filter['startDate'])
                ->where(DB::raw('DATE_FORMAT(updated_at, "%Y-%m")'), '<=', $filter['endDate']);
        })
            ->groupBy('date')
            ->orderBy('date', 'desc') // Order by updated_date, not DATE(updated_at)
            ->get();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'data' => $data]);
        }
    }

    public function chartSale(Request $request)
    {
        $filter = $request->all();
        $data = Sale::select([
            DB::raw('CONCAT(monthname(updated_at), " ", year(updated_at)) as date'),
            DB::raw('SUM(total_price) as total_sale')
        ])->when(!empty($filter['startDate']) && !empty($filter['endDate']), function ($query) use ($filter) {
            return $query->where(DB::raw('DATE_FORMAT(updated_at, "%Y-%m")'), '>=', $filter['startDate'])
                ->where(DB::raw('DATE_FORMAT(updated_at, "%Y-%m")'), '<=', $filter['endDate']);
        })
            ->groupBy('date')
            ->orderBy('date', 'desc') // Order by updated_date, not DATE(updated_at)
            ->get();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'data' => $data]);
        }
    }
}
