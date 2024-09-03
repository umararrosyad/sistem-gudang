<?php

namespace App\Http\Controllers\Api;
use App\Models\Kategori;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\KategoriResource;

use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all kategoris
        $kategori = Kategori::latest()->paginate(5);
        return new KategoriResource("success", 'List Data Kategori', $kategori);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                new KategoriResource("error", 'Validation Error', $validator->errors()),
                422
            );
        }

        $kategori = Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return new KategoriResource("success", 'Data Kategori Berhasil Ditambahkan!', $kategori);
    }

    public function show($id)
    {
        $kategori = Kategori::find($id);
        if ($kategori) {
            return new KategoriResource("success", 'Detail Data kategori!', $kategori);
        } else {
            return response()->json(
                new KategoriResource("error", 'Data kategori Tidak Ditemukan!', null),
                404
            );
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                new KategoriResource("error", 'Validation Error', $validator->errors()),
                422
            );
        }

        $kategori = Kategori::find($id);
        if ($kategori) {
            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
            ]);

            return new KategoriResource("success", 'Data Kategori Berhasil Diubah!', $kategori);
        } else {
            return response()->json(
                new KategoriResource("error", 'Data Kategori Tidak Ditemukan!', null),
                404
            );
        }
    }

    public function destroy($id)
    {
        $user = Kategori::find($id);

        if ($user) {
            // Jika pengguna ditemukan, hapus dan kembalikan respons sukses
            $user->delete();
            return new KategoriResource("success", 'Data Kategori Berhasil Dihapus!', null);
        } else {
            // Jika pengguna tidak ditemukan, kembalikan respons error
            return response()->json(
                new KategoriResource("error", 'Data Kategori Tidak Ditemukan!', null),
                404
            );
        }
    }

}
