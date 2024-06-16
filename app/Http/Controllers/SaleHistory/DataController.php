<?php

namespace App\Http\Controllers\SaleHistory;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DataController extends Controller
{
    public function delete(Request $request)
    {
        try {
            DB::connection('mysql')->beginTransaction();

            $data = Sale::findOrFail($request->input('id'));
            // dd($request->input('id'));

            SaleDetail::where('sale_id', $data->id)->delete();

            $data->delete();

            DB::connection('mysql')->commit();
            return back()->with('success', 'Berhasil menghapus penjualan');
        } catch (\Exception $e) {
            DB::connection('mysql')->rollback();
            return $this->error_handler($e);
        }
    }
}
