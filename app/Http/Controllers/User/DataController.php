<?php

namespace App\Http\Controllers\User;

use App\Models\User;
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
                DB::connection('mysql')->commit();
                return response()->json(['success' => true, 'message' => 'Berhasil mengubah data pengguna']);
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

            DB::connection('mysql')->commit();
            return back()->with('success', 'Berhasil menghapus pengguna');
        } catch (\Exception $e) {
            DB::connection('mysql')->rollback();
            return $this->error_handler($e);
        }
    }
}
