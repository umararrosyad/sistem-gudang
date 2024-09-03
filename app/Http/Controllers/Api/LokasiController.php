<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lokasi;


use App\Http\Resources\LokasiResource;

use Illuminate\Support\Facades\Validator;

class LokasiController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all kategoris
        $lokasi = Lokasi::latest()->paginate(5);
        return new LokasiResource("success", 'List Data Lokasi', $lokasi);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_lokasi' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                new LokasiResource("error", 'Validation Error', $validator->errors()),
                422
            );
        }

        $lokasi = Lokasi::create([
            'nama_lokasi' => $request->nama_lokasi,
            'alamat' => $request->alamat,
        ]);

        return new LokasiResource("success", 'Data lokasi Berhasil Ditambahkan!', $lokasi);
    }

    public function show($id)
    {
        $lokasi = Lokasi::find($id);

        if ($lokasi) {
            return new LokasiResource("success", 'Detail Data lokasi!', $lokasi);
        } else {
            return response()->json(
                new LokasiResource("error", 'Data lokasi Tidak Ditemukan!', null),
                404
            );
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_lokasi' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                new KategoriResource("error", 'Validation Error', $validator->errors()),
                422
            );
        }

        $lokasi = Lokasi::find($id);
        if ($lokasi) {
            $lokasi->update([
                'nama_lokasi' => $request->nama_lokasi,
                'alamat' => $request->alamat,
            ]);

            return new LokasiResource("success", 'Data Kategori Berhasil Diubah!', $lokasi);
        } else {
            return response()->json(
                new LokasiResource("error", 'Data Kategori Tidak Ditemukan!', null),
                404
            );
        }
    }

    public function destroy($id)
    {
        $lokasi = Lokasi::find($id);

        if ($lokasi) {
            // Jika pengguna ditemukan, hapus dan kembalikan respons sukses
            $lokasi->delete();
            return new LokasiResource("success", 'Data lokasi Berhasil Dihapus!', null);
        } else {
            // Jika pengguna tidak ditemukan, kembalikan respons error
            return response()->json(
                new LokasiResource("error", 'Data lokasi Tidak Ditemukan!', null),
                404
            );
        }
    }

}


