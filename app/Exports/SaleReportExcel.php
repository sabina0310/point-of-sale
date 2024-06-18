<?php

namespace App\Exports;

use App\Models\Sale;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SaleReportExcel implements FromView, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;


    public function __construct($filter)
    {
        $this->startDate = $filter['startDate'];
        $this->endDate = $filter['endDate'];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $query = Sale::with('SaleDetailsWithProduct')->where('status', 'success');
        if (!empty($this->startDate) && !empty($this->endDate)) {
            $query->whereDate('updated_at', '>=', $this->startDate)
                ->whereDate('updated_at', '<=', $this->endDate);
        } elseif (!empty($this->startDate)) {
            $query->whereDate('updated_at', '>=', $this->startDate);
        } elseif (!empty($this->endDate)) {
            $query->whereDate('updated_at', '<=', $this->endDate);
        }

        $data['listSaleReport'] = $query->orderBy('id', 'desc')->get();

        return view('export.saleReportExcel', $data);
    }
}
