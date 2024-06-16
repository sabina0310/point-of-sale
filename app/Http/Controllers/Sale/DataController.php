<?php

namespace App\Http\Controllers\Sale;

use PDO;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Models\SaleDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DataController extends Controller
{

    public function generateInvoiceNumber()
    {
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
        $data = 'PMN' . $date . str_pad($number, 4, '0', STR_PAD_LEFT);

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function submitProduct(Request $request)
    {
        $eloquent = null;
        $eloquentProduct = null;
        $saleDetail = null;

        $quantity = $request->quantity;
        $invoice_number = $request->invoice_number;
        $product_id = $request->product_id;

        $eloquent = Sale::where('invoice_number', $invoice_number)->first();
        $eloquentProduct = Product::find($product_id);

        $total_price = $quantity * $eloquentProduct->sale_price;
        $total_profit = ($quantity * $eloquentProduct->sale_price) - ($quantity * $eloquentProduct->price_per_purchase_item);


        try {
            DB::connection('mysql')->beginTransaction();

            if (!$eloquent) {
                if ($quantity > $eloquentProduct->stock) {
                    return response()->json(['success' => false, 'message' => 'Jumlah produk melebihi stok']);
                }

                $eloquent = new Sale;
                $eloquent->invoice_number = $invoice_number;
                $eloquent->total_price = $total_price;
                $eloquent->total_profit = $total_profit;
                $eloquent->status = 'pending';
                $eloquent->save();

                $saleDetail = new SaleDetail;
                $saleDetail->sale_id = $eloquent->id;
                $saleDetail->product_id = $product_id;
                $saleDetail->quantity = $quantity;
                $saleDetail->total_price = $eloquent->total_price;
                $saleDetail->total_profit = $eloquent->total_profit;
                $saleDetail->save();
                DB::connection('mysql')->commit();
            } else {

                $eloquentSaleDetail = SaleDetail::where('sale_id', $eloquent->id)->where('product_id', $product_id)->first();

                if (!$eloquentSaleDetail) {
                    $saleDetail = new SaleDetail;
                    $saleDetail->sale_id = $eloquent->id;
                    $saleDetail->product_id = $product_id;
                    $saleDetail->quantity = $quantity;
                    $saleDetail->total_price = $total_price;
                    $saleDetail->total_profit = $total_profit;
                    $saleDetail->save();

                    $eloquent->total_price += $saleDetail->total_price;
                    $eloquent->total_profit += $saleDetail->total_profit;
                    $eloquent->save();
                } else {
                    $totalQuantity = $eloquentSaleDetail->quantity + $quantity;
                    if ($totalQuantity > $eloquentProduct->stock) {
                        return response()->json(['success' => false, 'message' => 'Jumlah produk melebihi stok']);
                    }

                    $eloquentSaleDetail->quantity += $quantity;
                    $eloquentSaleDetail->total_price += $total_price;
                    $eloquentSaleDetail->total_profit += $total_profit;
                    $eloquentSaleDetail->save();

                    $eloquent->total_price += $total_price;
                    $eloquent->total_profit += $total_profit;
                    $eloquent->save();
                }

                DB::connection('mysql')->commit();
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::connection('mysql')->rollback();
            return $this->error_handler($e);
        }
    }

    public function submit(Request $request)
    {
        $eloquent = null;
        $invoice_number = $request->invoice_number;
        $payment_amount = $request->payment_amount;


        $eloquent = Sale::where('invoice_number', $invoice_number)->first();
        $eloquentSaleDetail = SaleDetail::where('sale_id', $eloquent->id)->get();

        try {
            DB::connection('mysql')->beginTransaction();

            foreach ($eloquentSaleDetail as $saleDetail) {
                $product = Product::find($saleDetail->product_id);
                $product->stock -= $saleDetail->quantity;
                $product->save();
            }

            $eloquent->status = 'success';
            $eloquent->payment_amount = $payment_amount;
            $eloquent->save();

            DB::connection('mysql')->commit();


            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::connection('mysql')->rollback();
            return $this->error_handler($e);
        }
    }

    public function cancel(Request $request)
    {
        try {
            DB::connection('mysql')->beginTransaction();

            $data = Sale::where('invoice_number', $request->input('invoice_number'))->first();

            SaleDetail::where('sale_id', $data->id)->delete();

            $data->delete();

            DB::connection('mysql')->commit();
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::connection('mysql')->rollback();
            return $this->error_handler($e);
        }
    }

    public function deleteCartProduct(Request $request)
    {
        try {
            DB::connection('mysql')->beginTransaction();

            // dd($request->input('id'));
            $data = SaleDetail::findOrFail($request->input('id'));

            $dataSale = Sale::find($data->sale_id)->first();

            $dataSaleDetail = SaleDetail::where('sale_id', $data->sale_id)->get();

            if (count($dataSaleDetail) > 1) {
                $dataSale->total_price -= $data->total_price;
                $dataSale->total_profit -= $data->total_profit;
                $dataSale->save();
                $reload = false;
            } else {
                $dataSale->delete();
                $reload = true;
            }
            $data->delete();
            DB::connection('mysql')->commit();

            return response()->json(['success' => true, 'reload' => $reload]);
        } catch (\Exception $e) {
            DB::connection('mysql')->rollback();
            return $this->error_handler($e);
        }
    }
}
