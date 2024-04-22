<?php

namespace App\Http\Controllers\Product;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DataController extends Controller
{
    public function submit()
    {
        $eloquent = null;
        if (!empty(request()->input('id'))) {
            $eloquent =  Category::find(request()->input('id'));
        }

        try {
            DB::connection('mysql')->beginTransaction();

            if (!isset($eloquent)) {
                $eloquent = new Category;
                $eloquent->name = request()->input('name');
                $eloquent->save();
                DB::connection('mysql')->commit();
                return back()->with('success', 'Berhasil menambahkan data kategori');
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

            $data = Category::findOrFail($request->input('id'));

            $data->delete();

            DB::connection('mysql')->commit();
            return back()->with('success', 'Berhasil menghapus kategori');
        } catch (\Exception $e) {
            DB::connection('mysql')->rollback();
            return $this->error_handler($e);
        }
    }
}
