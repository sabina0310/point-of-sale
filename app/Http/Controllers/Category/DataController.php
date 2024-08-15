<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ActivityLogs;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    public function submit(Request $request)
    {
        $messages = [
            'name.required' => 'Nama kategori wajib diisi.'
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()],  422);
        }

        $eloquent = null;
        if (!empty(request()->input('id'))) {
            $eloquent =  Category::find(request()->input('id'));
        }

        try {
            DB::connection('mysql')->beginTransaction();

            if (!isset($eloquent)) {
                $lastRecord = Category::orderBy('id', 'desc')->first();
                $lastId = $lastRecord ? $lastRecord->id : 0;
                $newId = $lastId + 1;
                $newCode = 'K' . str_pad($newId, 3, '0', STR_PAD_LEFT);

                $eloquent = new Category;
                $eloquent->category_code = $newCode;
                $eloquent->name = request()->input('name');

                $eloquent->save();

                $dataLog = [
                    'log_type' => 'create',
                    'model' => 'category',
                    'message' => 'menambah data kategori "' . $eloquent->name . '" ke dalam master kategori',
                    'data' => json_encode($eloquent)
                ];
                ActivityLogs::createLogs($dataLog);

                DB::connection('mysql')->commit();

                return response()->json(['success' => true, 'message' => 'Berhasil menambah data kategori']);
            } else {
                $eloquent->name = request()->input('name');
                $eloquent->save();
                $dataLog = [
                    'log_type' => 'update',
                    'model' => 'category',
                    'message' => 'mengedit data kategori "' . $eloquent->name . '" di master kategori',
                    'data' => json_encode($eloquent)
                ];
                ActivityLogs::createLogs($dataLog);

                DB::connection('mysql')->commit();
                return response()->json(['success' => true, 'message' => 'Berhasil mengedit data kategori']);
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
            $dataLog = [
                'log_type' => 'delete',
                'model' => 'category',
                'message' => 'menghapus data kategori "' . $data->name . '" di master kategori',
                'data' => json_encode($data)
            ];
            ActivityLogs::createLogs($dataLog);

            DB::connection('mysql')->commit();
            return back()->with('success', 'Berhasil menghapus kategori');
        } catch (\Exception $e) {
            DB::connection('mysql')->rollback();
            return $this->error_handler($e);
        }
    }
}
