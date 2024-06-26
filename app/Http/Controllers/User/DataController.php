<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\ActivityLogs;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    public function submit(Request $request)
    {
        $messages = [
            'name.required' => 'Nama produk wajib diisi.',
            'role.required' => 'Role wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan, silakan pilih username lain.',

        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'role' => 'required',
            'username' => ['required', Rule::unique('m_user')->ignore(auth()->user()->id)],
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()],  422);
        }
        $eloquent = null;
        if (!empty(request()->input('id'))) {
            $eloquent =  User::find(request()->input('id'));
        }

        try {
            DB::connection('mysql')->beginTransaction();

            if (!isset($eloquent)) {
                $eloquent = new User;
                $eloquent->name = request()->input('name');
                $eloquent->username = request()->input('username');
                $eloquent->role = request()->input('role');
                $eloquent->password = request()->input('password') != null ? request()->input('password') : '123';
                $eloquent->save();

                $dataLog = [
                    'log_type' => 'create',
                    'model' => 'user',
                    'message' => 'menambah data pengguna "' . $eloquent->name . '" di master pengguna',
                    'data' => json_encode($eloquent)
                ];
                ActivityLogs::createLogs($dataLog);

                DB::connection('mysql')->commit();
                return response()->json(['success' => true, 'message' => 'Berhasil menambah data pengguna']);
            } else {
                $eloquent->name = request()->input('name');
                $eloquent->username = request()->input('username');
                $eloquent->role = request()->input('role');
                if (request()->input('password') != null) {
                    $eloquent->password = bcrypt(request()->input('password'));
                }
                $eloquent->save();

                $dataLog = [
                    'log_type' => 'update',
                    'model' => 'user',
                    'message' => 'mengedit data pengguna "' . $eloquent->name . '" di master pengguna',
                    'data' => json_encode($eloquent)
                ];
                ActivityLogs::createLogs($dataLog);

                DB::connection('mysql')->commit();
                return response()->json(['success' => true, 'message' => 'Berhasil mengedit data pengguna']);
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

            $data = User::findOrFail($request->input('id'));
            $data->delete();

            $dataLog = [
                'log_type' => 'delete',
                'model' => 'user',
                'message' => 'menghapus data pengguna "' . $data->name . '" di master pengguna',
                'data' => json_encode($data)
            ];
            ActivityLogs::createLogs($dataLog);

            DB::connection('mysql')->commit();
            return back()->with('success', 'Berhasil menghapus pengguna');
        } catch (\Exception $e) {
            DB::connection('mysql')->rollback();
            return $this->error_handler($e);
        }
    }
}
