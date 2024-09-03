<?php

namespace App\Http\Controllers\Api;
use App\Models\JenisMutasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\JenisMutasiResource;

use Illuminate\Support\Facades\Validator;

class JenisMutasiController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all JenisMutasis
        $JenisMutasi = JenisMutasi::latest()->paginate(5);
        return new JenisMutasiResource("success", 'List Data JenisMutasi', $JenisMutasi);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_jenis_mutasi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                new JenisMutasiResource("error", 'Validation Error', $validator->errors()),
                422
            );
        }

        $JenisMutasi = JenisMutasi::create([
            'nama_jenis_mutasi' => $request->nama_jenis_mutasi,
        ]);

        return new JenisMutasiResource("success", 'Data JenisMutasi Berhasil Ditambahkan!', $JenisMutasi);
    }

    public function show($id)
    {
        $JenisMutasi = JenisMutasi::find($id);
        if ($JenisMutasi) {
            return new JenisMutasiResource("success", 'Detail Data Jenis Mutasi!', $JenisMutasi);
        } else {
            return response()->json(
                new JenisMutasiResource("error", 'Data Jenis Mutasi Tidak Ditemukan!', null),
                404
            );
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_jenis_mutasi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                new JenisMutasiResource("error", 'Validation Error', $validator->errors()),
                422
            );
        }

        $JenisMutasi = JenisMutasi::find($id);
        if ($JenisMutasi) {
            $JenisMutasi->update([
                'nama_jenis_mutasi' => $request->nama_jenis_mutasi,
            ]);

            return new JenisMutasiResource("success", 'Data JenisMutasi Berhasil Diubah!', $JenisMutasi);
        } else {
            return response()->json(
                new JenisMutasiResource("error", 'Data JenisMutasi Tidak Ditemukan!', null),
                404
            );
        }
    }

    public function destroy($id)
    {
        $jenisMutasi = JenisMutasi::find($id);

        if ($jenisMutasi) {
            // Jika pengguna ditemukan, hapus dan kembalikan respons sukses
            $jenisMutasi->delete();
            return new JenisMutasiResource("success", 'Data JenisMutasi Berhasil Dihapus!', null);
        } else {
            // Jika pengguna tidak ditemukan, kembalikan respons error
            return response()->json(
                new JenisMutasiResource("error", 'Data Kategori Tidak Ditemukan!', null),
                404
            );
        }
    }

}
