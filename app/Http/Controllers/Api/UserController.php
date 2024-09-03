<?php

namespace App\Http\Controllers\Api;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\UserResource;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $user = User::latest()->paginate(5);
        return new UserResource("success", 'List Data User', $user);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
           'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(
                new UserResource("error", 'Validation Error', $validator->errors()),
                422
            );
        }

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return new UserResource("success", 'Data User Berhasil Ditambahkan!', $user);
    }

    public function show($id)
    {
        $User = User::find($id);

        if ($User) {
            return new UserResource("success", 'Detail Data User!', $User);
        } else {
            return response()->json(
                new UserResource("error", 'Data User Tidak Ditemukan!', null),
                404
            );
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(
                new UserResource("error", 'Validation Error', $validator->errors()),
                422
            );
        }

        $user = User::find($id);
        if ($user) {
            $user->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Kembalikan respons
            return new UserResource("success", 'Data User Berhasil Diubah!', $user);
        } else {
            // Jika pengguna tidak ditemukan, kembalikan respons error
            return response()->json(
                new UserResource("error", 'Data User Tidak Ditemukan!', null),
                404
            );
        }

    }

    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            // Jika pengguna ditemukan, hapus dan kembalikan respons sukses
            $user->delete();
            return new UserResource("success", 'Data User Berhasil Dihapus!', null);
        } else {
            // Jika pengguna tidak ditemukan, kembalikan respons error
            return response()->json(
                new UserResource("error", 'Data User Tidak Ditemukan!', null),
                404
            );
        }
    }

}
