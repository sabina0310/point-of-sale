<?php

namespace App\Http\Controllers\SaleHistory;

use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DataController extends Controller
{
    public function delete(Request $request)
    {
        try {
            DB::connection('mysql')->beginTransaction();

            $data = Sale::findOrFail($request->input('id'));
            $dataSaleDetail = SaleDetail::where('sale_id', $data->id)->first();
            // dd($data->status == 'success');
            if ($data->status == 'success') {
                $product = Product::find($dataSaleDetail->product_id);
                $product->stock += $dataSaleDetail->quantity;
                $product->save();
            }

            $data->delete();
            $dataSaleDetail->delete();

            DB::connection('mysql')->commit();
            return back()->with('success', 'Berhasil menghapus penjualan');
        } catch (\Exception $e) {
            DB::connection('mysql')->rollback();
            return $this->error_handler($e);
        }
    }
}
