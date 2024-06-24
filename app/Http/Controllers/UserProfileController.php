<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    public function show()
    {
        return view('pages.user-profile');
    }

    public function update(Request $request)
    {
        $messages = [
            'name.required' => 'Nama produk wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan, silakan pilih username lain.',

        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => ['required', Rule::unique('m_user')->ignore(auth()->user()->id)],
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()],  422);
        }

        try {
            DB::connection('mysql')->beginTransaction();

            $eloquent = User::find(auth()->user()->id);
            $eloquent->username = $request->username;
            $eloquent->name = $request->name;

            if ($request->password != null) {
                $eloquent->role = bcrypt($request->password);
            }
            $eloquent->save();
            DB::connection('mysql')->commit();
        } catch (\Exception $e) {
            DB::connection('mysql')->rollback();
            return $this->error_handler($e);
        }

        return response()->json(['success' => true, 'message' => 'Berhasil mengubah profil']);

    }
}
