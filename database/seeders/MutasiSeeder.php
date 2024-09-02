<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class MutasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mutasis')->insert([
            [
                'user_id' => '1',
                'barang_kode' => 'BRG001',
                'jenis_mutasi_id' => '1',
                'tanggal' => '2024-02-02',
                'jumlah' => '4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => '2',
                'barang_kode' => 'BRG002',
                'jenis_mutasi_id' => '2',
                'tanggal' => '2024-02-02',
                'jumlah' => '4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => '2',
                'barang_kode' => 'BRG003',
                'jenis_mutasi_id' => '2',
                'tanggal' => '2024-02-02',
                'jumlah' => '4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
