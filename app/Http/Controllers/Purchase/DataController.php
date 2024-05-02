<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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

    public function submit()
    {
        $eloquent = null;
        if (!empty(request()->input('id'))) {
            $eloquent =  Purchase::find(request()->input('id'));
        }

        try {
            DB::connection('mysql')->beginTransaction();

            if (!isset($eloquent)) {
                $eloquent = new Purchase();


                $eloquent->product_id = request()->input('product_id');
                $eloquent->quantity = request()->input('quantity');
                $eloquent->total_price = request()->input('total_price');
                $eloquent->date = request()->input('date');
                $eloquent->save();

                $product = Product::where('id', request()->input('product_id'))->first();
                $quantity = request()->input('quantity');
                $product->stock += $quantity;
                $product->save();

                DB::connection('mysql')->commit();
                return redirect()->route('purchase')->with('success', 'Berhasil menambahkan data pembelian');
            } else {
                $eloquent->name = request()->input('name');
                $eloquent->save();
                DB::connection('mysql')->commit();
                return back()->with('success', 'Berhasil mengubah data kategori');
            }
        } catch (\Exception $e) {
            DB::connection('mysql')->rollback();
            return $this->error_handler($e);
        }
    }
}
