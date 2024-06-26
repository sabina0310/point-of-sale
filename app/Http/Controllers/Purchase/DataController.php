<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\ActivityLogs;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    public function showProduct($id = null)
    {
        $data = Product::where('id', $id)->first();
        // dd($id);
        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ]);
        }
    }

    public function submit(Request $request)
    {

        $messages = [
            'product_id.required' => 'Produk produk wajib diisi.',
            'purchase_quantity.required' => 'Jumlah pembelian wajib diisi.',
            'date.required' => 'Tanggal wajib diisi.'
        ];

        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'purchase_quantity' => 'required',
            'date' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()],  422);
        }

        $eloquent = null;
        if (!empty(request()->input('id'))) {
            $eloquent =  Purchase::find(request()->input('id'));
        }

        try {
            DB::connection('mysql')->beginTransaction();

            if (!isset($eloquent)) {

                $eloquent = new Purchase();
                $eloquent->purchase_number = request()->input('purchase_number');
                $eloquent->product_id = request()->input('product_id');
                $eloquent->purchase_quantity = request()->input('purchase_quantity');
                $eloquent->purchase_stock = request()->input('purchase_stock');
                $eloquent->total_price = request()->input('total_price');
                $eloquent->date = request()->input('date');
                $eloquent->save();

                $product = Product::where('id', request()->input('product_id'))->first();
                $product->stock += $eloquent->purchase_stock;
                $product->save();

                $dataLog = [
                    'log_type' => 'create',
                    'model' => 'purchase',
                    'message' => 'menambah data "' . $eloquent->purchase_number . '" di transaksi pembelian',
                    'data' => json_encode($eloquent)
                ];
                ActivityLogs::createLogs($dataLog);

                DB::connection('mysql')->commit();
                return response()->json(['success' => true, 'message' => 'Berhasil menambah data pembelian']);
            } else {
                $eloquent->date = request()->input('date');

                if ($eloquent->purchase_quantity != request()->input('purchase_quantity')) {

                    $eloquent->purchase_quantity = request()->input('purchase_quantity');

                    $product = Product::where('id', $eloquent->product_id)->first();
                    $updatedStock = request()->input('purchase_stock') - $eloquent->purchase_stock;

                    $product->stock += $updatedStock;
                    $product->save();
                    $dataLog = [
                        'log_type' => 'update',
                        'model' => 'purchase',
                        'message' => 'mengedit data pembelian "' . $eloquent->purchase_number . '" di transaksi pembelian',
                        'data' => json_encode($eloquent)
                    ];
                    ActivityLogs::createLogs($dataLog);

                    $eloquent->purchase_stock = request()->input('purchase_stock');
                }
                $eloquent->save();
                DB::connection('mysql')->commit();
                return response()->json(['success' => true, 'message' => 'Berhasil mengubah data pembelian']);
            }
        } catch (\Exception $e) {
            DB::connection('mysql')->rollback();
            return $this->error_handler($e);
        }
    }

    public function delete(Request $request)
    {
        try {
            DB::connection('mysql')->beginTransaction();

            $data = Purchase::findOrFail($request->input('id'));

            $product = Product::find($data->product_id);
            $product->stock -= $data->purchase_stock;
            $product->save();

            $data->delete();

            $dataLog = [
                'log_type' => 'delete',
                'model' => 'purchase',
                'message' => 'menghapus data pembelian "' . $data->purchase_number . '" di transaksi pembelian',
                'data' => json_encode($data)
            ];
            ActivityLogs::createLogs($dataLog);

            DB::connection('mysql')->commit();
            return back()->with('success', 'Berhasil menghapus produk');
        } catch (\Exception $e) {
            DB::connection('mysql')->rollback();
            return $this->error_handler($e);
        }
    }
}
