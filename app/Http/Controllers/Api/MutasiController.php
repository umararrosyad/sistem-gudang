<?php

namespace App\Http\Controllers\Api;
use App\Models\Mutasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\MutasiResource;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class MutasiController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $mutasi = Mutasi::select('mutasis.*', 'barangs.nama_barang as nama_barang', 'users.nama as nama', 'jenis_mutasis.nama_jenis_mutasi as nama_jenis_mutaisis ')
                    ->join('users', 'mutasis.user_id', '=', 'users.id')
                    ->join('barangs', 'mutasis.barang_kode', '=', 'barangs.kode')
                    ->join('jenis_mutasis', 'mutasis.jenis_mutasi_id', '=', 'jenis_mutasis.id')
                    ->latest()
                    ->paginate(5);

        return new MutasiResource("success", 'List Data Mutasi', $mutasi);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'user_id' =>  'required|integer',
            'barang_kode' => 'required',
            'jenis_mutasi_id' => 'required|integer',
            'jumlah' => 'required|integer',
            'tanggal' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json(
                new MutasiResource("error", 'Validation Error', $validator->errors()),
                422
            );
        }

        $mutasi = Mutasi::create([
            'user_id' => $request->user_id,
            'barang_kode' => $request->barang_kode,
            'jenis_mutasi_id' => $request->jenis_mutasi_id,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
        ]);

        return new MutasiResource("success", 'Data Mutasi Berhasil Ditambahkan!', $mutasi);
    }

    public function show($id)
    {
        $mutasi = Mutasi::select('mutasis.*', 'barangs.nama_barang as nama_barang', 'users.nama as nama', 'jenis_mutasis.nama_jenis_mutasi as nama_jenis_mutaisis ')
                    ->join('users', 'mutasis.user_id', '=', 'users.id')
                    ->join('barangs', 'mutasis.barang_kode', '=', 'barangs.kode')
                    ->join('jenis_mutasis', 'mutasis.jenis_mutasi_id', '=', 'jenis_mutasis.id')
                    ->where('mutasis.id', $id)
                    ->first();

        if ($mutasi) {
            return new MutasiResource("success", 'Detail Data Mutasi!', $mutasi);
        } else {
            return response()->json(
                new MutasiResource("error", 'Data Mutasi Tidak Ditemukan!', null),
                404
            );
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' =>  'required|integer',
            'barang_kode' => 'required',
            'jenis_mutasi_id' => 'required|integer',
            'jumlah' => 'required|integer',
            'tanggal' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json(
                new MutasiResource("error", 'Validation Error', $validator->errors()),
                422
            );
        }

        $mutasi = Mutasu::find($id);
        if ($mutasi) {
            $mutasi->update([
                'user_id' => $request->user_id,
                'barang_kode' => $request->barang_kode,
                'jenis_mutasi_id' => $request->jenis_mutasi_id,
                'jumlah' => $request->jumlah,
                'tanggal' => $request->tanggal,
            ]);

            // Kembalikan respons
            return new MutasiResource("success", 'Data Mutasi Berhasil Diubah!', $mutasi);
        } else {
            // Jika pengguna tidak ditemukan, kembalikan respons error
            return response()->json(
                new MutasiResource("error", 'Data Mutasi Tidak Ditemukan!', null),
                404
            );
        }

    }

    public function destroy($id)
    {
        $mutasi = Mutasi::find($id);

        if ($mutasi) {
            // Jika pengguna ditemukan, hapus dan kembalikan respons sukses
            $mutasi->delete();
            return new BarangResource("success", 'Data Mutasi Berhasil Dihapus!', null);
        } else {
            // Jika pengguna tidak ditemukan, kembalikan respons error
            return response()->json(
                new BarangResource("error", 'Data Mutasi Tidak Ditemukan!', null),
                404
            );
        }
    }

    public function mutasiUser($id)
    {
        $mutasi = Mutasi::select('mutasis.*', 'barangs.nama_barang as nama_barang', 'users.nama as nama', 'jenis_mutasis.nama_jenis_mutasi as nama_jenis_mutaisis ')
                    ->join('users', 'mutasis.user_id', '=', 'users.id')
                    ->join('barangs', 'mutasis.barang_kode', '=', 'barangs.kode')
                    ->join('jenis_mutasis', 'mutasis.jenis_mutasi_id', '=', 'jenis_mutasis.id')
                    ->where('user.id', $id)
                    ->first();

        if ($mutasi) {
            return new MutasiResource("success", 'Detail Data Mutasi!', $mutasi);
        } else {
            return response()->json(
                new MutasiResource("error", 'Data Mutasi Tidak Ditemukan!', null),
                404
            );
        }
    }

    public function mutasiBarang($id)
    {
        $mutasi = Mutasi::select('mutasis.*', 'barangs.nama_barang as nama_barang', 'users.nama as nama', 'jenis_mutasis.nama_jenis_mutasi as nama_jenis_mutaisis ')
                    ->join('users', 'mutasis.user_id', '=', 'users.id')
                    ->join('barangs', 'mutasis.barang_kode', '=', 'barangs.kode')
                    ->join('jenis_mutasis', 'mutasis.jenis_mutasi_id', '=', 'jenis_mutasis.id')
                    ->where('barangs.kode', $id)
                    ->first();

        if ($mutasi) {
            return new MutasiResource("success", 'Detail Data Mutasi!', $mutasi);
        } else {
            return response()->json(
                new MutasiResource("error", 'Data Mutasi Tidak Ditemukan!', null),
                404
            );
        }
    }

}
