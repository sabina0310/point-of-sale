<?php

namespace App\Http\Controllers\Product;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Product;

class DataController extends Controller
{
    public function submit()
    {
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
                $eloquent->selling_unit = request()->input('selling_unit');
                $eloquent->selling_price = request()->input('selling_price');
                $eloquent->stock = 0;
                $eloquent->save();
                DB::connection('mysql')->commit();
                return redirect()->route('product')->with('success', 'Berhasil menambahkan data produk');
                // return back()->with('success', 'Berhasil menambahkan data produk');
            } else {
                $eloquent->name = request()->input('name');
                $eloquent->category_id = request()->input('category_id');
                $eloquent->purchase_unit = request()->input('purchase_unit');
                $eloquent->purchase_price = request()->input('purchase_price');
                $eloquent->quantity_per_purchase_unit = request()->input('quantity_per_purchase_unit');
                $eloquent->price_per_purchase_item = request()->input('price_per_purchase_item');
                $eloquent->selling_unit = request()->input('selling_unit');
                $eloquent->selling_price = request()->input('selling_price');
                $eloquent->save();
                DB::connection('mysql')->commit();
                return redirect()->route('product')->with('success', 'Berhasil mengubah data produk');
                // return back()->with('success', 'Berhasil mengubah data produk');
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

            DB::connection('mysql')->commit();
            return back()->with('success', 'Berhasil menghapus produk');
        } catch (\Exception $e) {
            DB::connection('mysql')->rollback();
            return $this->error_handler($e);
        }
    }
}
