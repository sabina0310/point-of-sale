<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use App\Models\Category;
use App\Models\ActivityLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    public function submit(Request $request)
    {
        $messages = [
            'category_id.required' => 'Kategori produk wajib diisi.',
            'name.required' => 'Nama produk wajib diisi.',
            'purchase_unit.required' => 'Satuan beli wajib diisi.',
            'purchase_price.required' => 'Harga beli wajib diisi.',
            'quantity_per_purchase_unit.required' => 'Isi per satuan beli wajib diisi.',
            'quantity_per_purchase_unit.required' => 'Isi per satuan beli wajib diisi.',
            'price_per_purchase_item.required' => 'Harga per item wajib diisi.',
            'sale_unit.required' => 'Satuan jual wajib diisi.',
            'sale_price.required' => 'Harga jual wajib diisi.',
        ];

        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'name' => 'required',
            'purchase_unit' => 'required',
            'purchase_price' => 'required',
            'quantity_per_purchase_unit' => 'required',
            'quantity_per_purchase_unit' => 'required',
            'price_per_purchase_item' => 'required',
            'sale_unit' => 'required',
            'sale_price' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()],  422);
        }

        $eloquent = null;
        if (!empty(request()->input('id'))) {
            $eloquent =  Product::find(request()->input('id'));
        }

        try {
            DB::connection('mysql')->beginTransaction();

            if (!isset($eloquent)) {
                $eloquent = new Product();
                $eloquent->name = request()->input('name');
                $eloquent->category_id = request()->input('category_id');
                $eloquent->purchase_unit = request()->input('purchase_unit');
                $eloquent->purchase_price = request()->input('purchase_price');
                $eloquent->quantity_per_purchase_unit = request()->input('quantity_per_purchase_unit');
                $eloquent->price_per_purchase_item = request()->input('price_per_purchase_item');
                $eloquent->sale_unit = request()->input('sale_unit');
                $eloquent->sale_price = request()->input('sale_price');
                $eloquent->stock = 0;
                $eloquent->save();
                $dataLog = [
                    'log_type' => 'create',
                    'model' => 'product',
                    'message' => 'menambah data produk "' . $eloquent->name . '" di master produk',
                    'data' => json_encode($eloquent)
                ];
                ActivityLogs::createLogs($dataLog);

                DB::connection('mysql')->commit();
                return response()->json(['success' => true, 'message' => 'Berhasil menambah data produk']);
            } else {
                $eloquent->name = request()->input('name');
                $eloquent->category_id = request()->input('category_id');
                $eloquent->purchase_unit = request()->input('purchase_unit');
                $eloquent->purchase_price = request()->input('purchase_price');
                $eloquent->quantity_per_purchase_unit = request()->input('quantity_per_purchase_unit');
                $eloquent->price_per_purchase_item = request()->input('price_per_purchase_item');
                $eloquent->sale_unit = request()->input('sale_unit');
                $eloquent->sale_price = request()->input('sale_price');
                $eloquent->save();

                $dataLog = [
                    'log_type' => 'update',
                    'model' => 'product',
                    'message' => 'mengedit data produk "' . $eloquent->name . '" di master produk',
                    'data' => json_encode($eloquent)
                ];
                ActivityLogs::createLogs($dataLog);
                // dd($dataLog);

                DB::connection('mysql')->commit();
                return response()->json(['success' => true, 'message' => 'Berhasil mengedit data produk']);
            }
        } catch (\Exception $e) {
            DB::connection('mysql')->rollback();
            return $this->error_handler($e);
        }
    }


    public function show(int $id)
    {
        $data = Category::findOrFail($id);

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

    public function delete(Request $request)
    {
        try {
            DB::connection('mysql')->beginTransaction();

            $data = Product::findOrFail($request->input('id'));

            $data->delete();
            $dataLog = [
                'log_type' => 'delete',
                'model' => 'product',
                'message' => 'menghapus data produk "' . $data->name . '" di master produk',
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

    public function importExcel(Request $request)
    {
        $import = new ProductImport();
        Excel::import($import, $request->file('file_excel'));

        // Get imported data
        $data = $import->getImportedData();
        
        $dataLog = [
            'log_type' => 'create',
            'model' => 'product',
            'message' => 'mengimport data produk di master produk',
            'data' => json_encode($data)
        ];
        ActivityLogs::createLogs($dataLog);

        return response()->json(['success' => true, 'message' => 'Berhasil import data produk']);
    }
}
