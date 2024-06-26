<?php

namespace App\Http\Controllers\Sale;

use App\Models\Sale;
use App\Models\Product;
use Barryvdh\DomPDF\PDF as PDF;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{
    public function index(Request $request)
    {
        $invoice_number = $request->invoice_number;
        if ($invoice_number == null) {
            $date = Carbon::now()->format('ymd');
            $latestInvoice = Sale::whereDate('created_at', Carbon::today())
                ->orderBy('created_at', 'desc')
                ->first();

            if ($latestInvoice) {
                // Extract the last 4 digits and increment by 1
                $lastInvoiceNumber = substr($latestInvoice->invoice_number, -4);
                $number = intval($lastInvoiceNumber) + 1;
            } else {
                // If no invoice found, start with 1
                $number = 1;
            }

            // Pad the number to 4 digits with leading zeros
            $data['invoice_number'] = 'RCP' . $date . str_pad($number, 4, '0', STR_PAD_LEFT);
        } else {
            $data['invoice_number'] = $invoice_number;
        }

        return view('pages.selling.index', $data);
    }

    public function filter(Request $request)
    {
        $filter = $request->all();
        $data['listSale'] = collect();

        if (isset($filter['search'])) {
            $data['listSale'] = Product::orderByDesc('m_product.id')
                ->where('m_product.name', 'like', '%' . $filter['search'] . '%')
                ->get();
        }

        if ($request->ajax()) {
            return view('pages.selling.partials.tableListSellingProduct', $data);
        }
        return view('pages.selling.index', $data);
    }

    public function form($id = null)
    {
        // $data['product'] = Product::all();
        // $data['purchase'] = Purchase::where('id', $id)->first();

        // return view('pages.purchase.form', $data);
    }

    public function receiptProduct(Request $request)
    {
        $invoice_number = $request->invoice_number;

        $dataSale = Sale::where('invoice_number', $invoice_number)->first();

        if ($dataSale == null) {
            $data['sale'] = collect();
            $data['sale_detail'] = collect();
        } else {
            $data['sale'] = $dataSale->toArray();
            // dd($data['selling']);
            $data['sale_detail'] = SaleDetail::join('m_product', 'm_product.id', '=', 't_sale_detail.product_id')->select('t_sale_detail.id as id', 'm_product.name as product_name', 'm_product.sale_unit as product_unit', 'm_product.sale_price as product_price', 't_sale_detail.quantity as quantity', 't_sale_detail.total_price as total_price')->where('sale_id', $dataSale->id)->get();
        }


        if ($request->ajax()) {
            return view('pages.selling.partials.listReceiptProduct', $data);
        }
        return view('pages.selling.index', $data);
    }
}
