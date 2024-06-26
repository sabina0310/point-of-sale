<?php

namespace App\Http\Controllers\Generate;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Models\Sale;

class ReceiptController extends Controller
{
    public function generateReceipt(Request $request)
    {
        $data['sale'] = Sale::with('SaleDetailsWithProduct')->with('user')->where('invoice_number', $request->invoice_number)->first();
        // dd($data);
        $pdf = PDF::loadView('export.generateReceipt', $data);
        $pdf->setPaper(['0', '0', '377.9527559', '2500']);


        return $pdf->stream();

        // $receiptContent = view('export.generateReceipt', $data)->render();
        // return $this->printReceipt($receiptContent);
    }

    protected function printReceipt($content)
    {
        // Use JavaScript to open print dialog and print the receipt
        return view('export.print', ['content' => $content]);
    }
}
