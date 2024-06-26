<?php

namespace App\Http\Controllers\Purchase;


use App\Models\Product;
use App\Models\Category;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{
    public function index()
    {
        return view('pages.purchase.index');
    }

    public function filter(Request $request)
    {
        $filter = $request->all();

        $data['listPurchase'] = Purchase::join('m_product', 'm_product.id', 't_purchase.product_id')
            ->select('t_purchase.*', 'm_product.name as product_name')
            ->when(!empty($filter['search']), function ($query) use ($filter) {
                return $query->where('m_product.name', 'like', '%' . $filter['search'] . '%');
            })
            ->orderByDesc('t_purchase.date')
            ->paginate(2);

        if ($request->ajax()) {
            return view('pages.purchase.partials.tableListPurchase', $data);
        }

        return view('pages.purchase.index');
    }

    public function form($id = null)
    {
        $date = Carbon::now()->format('ymd');
        $latestInvoice = Purchase::whereDate('created_at', Carbon::today())
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
        $data['purchase_number'] = 'PURC' . $date . str_pad($number, 4, '0', STR_PAD_LEFT);
        $data['product'] = Product::all();
        $data['purchase'] = Purchase::where('id', $id)->first();
        if ($data['purchase']) {
            $data['purchase_product'] = Product::where('id', $data['purchase']->product_id)->first();
        } else {
            $data['purchase_product'] = collect();
        }


        return view('pages.purchase.form', $data);
    }
}
