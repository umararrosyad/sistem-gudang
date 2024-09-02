<?php

namespace App\Http\Controllers\Api;
use App\Models\Barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\BarangResource;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class BarangController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $barang = Barang::select('barangs.*', 'kategoris.nama_kategori as kategori_nama', 'lokasis.nama_lokasi as lokasi_nama')
                    ->join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
                    ->join('lokasis', 'barangs.lokasi_id', '=', 'lokasis.id')
                    ->latest()
                    ->paginate(5);

        return new BarangResource("success", 'List Data barang', $barang);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'kode' => 'required',
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|integer',
            'lokasi_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(
                new BarangResource("error", 'Validation Error', $validator->errors()),
                422
            );
        }

        $barang = Barang::create([
            'kode' => $request->kode,
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'lokasi_id' => $request->lokasi_id,
        ]);

        return new BarangResource("success", 'Data barang Berhasil Ditambahkan!', $barang);
    }

    public function show($id)
    {
        $barang = Barang::select('barangs.*', 'kategoris.nama_kategori as kategori_nama', 'lokasis.nama_lokasi as lokasi_nama')
                        ->join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
                        ->join('lokasis', 'barangs.lokasi_id', '=', 'lokasis.id')
                        ->where('barangs.kode', $id)
                        ->first();

        if ($barang) {
            return new BarangResource("success", 'Detail Data barang!', $barang);
        } else {
            return response()->json(
                new BarangResource("error", 'Data barang Tidak Ditemukan!', null),
                404
            );
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|integer',
            'lokasi_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(
                new BarangResource("error", 'Validation Error', $validator->errors()),
                422
            );
        }

        $barang = Barang::find($id);
        if ($barang) {
            $barang->update([
                'nama_barang' => $request->nama_barang,
                'kategori_id' => $request->kategori_id,
                'lokasi_id' => $request->lokasi_id,
            ]);

            // Kembalikan respons
            return new BarangResource("success", 'Data barang Berhasil Diubah!', $barang);
        } else {
            // Jika pengguna tidak ditemukan, kembalikan respons error
            return response()->json(
                new BarangResource("error", 'Data barang Tidak Ditemukan!', null),
                404
            );
        }

    }

    public function destroy($id)
    {
        $barang = Barang::find($id);

        if ($barang) {
            // Jika pengguna ditemukan, hapus dan kembalikan respons sukses
            $barang->delete();
            return new BarangResource("success", 'Data barang Berhasil Dihapus!', null);
        } else {
            // Jika pengguna tidak ditemukan, kembalikan respons error
            return response()->json(
                new BarangResource("error", 'Data barang Tidak Ditemukan!', null),
                404
            );
        }
    }

}
