<?php

use Illuminate\Database\Seeder;

class DinasregularTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('dinasregular')->delete();
        
        \DB::table('dinasregular')->insert(array (
            0 => 
            array (
                'id' => 2,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 2,
                'irban_id' => 1,
                'nomor_sp' => '123456789',
                'tgl_sp' => '2020-03-21',
                'dasar' => '["Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis lacus tortor.", "Aenean tincidunt dolor iaculis, ornare metus a, aliquet quam.", "Vivamus ac elit euismod, pretium mauris vel, tristique massa."]',
                'untuk' => '["Vivamus ac elit euismod, pretium mauris vel, tristique massa.", "Aenean tincidunt dolor iaculis, ornare metus a, aliquet quam.", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis lacus tortor."]',
                'auditan' => 'Kota Bogor',
                'dari' => '2020-03-14',
                'sampai' => '2020-03-18',
                'tim' => '[{"nip": "196009151981031007", "hari": 4, "nama": "Drs. KARYONO, M.Si.", "jabatan": "Pengawas Pemerintahan Madya", "pangkat": "Pembina Tk.I", "golongan": "IV/b", "biaya_harian": 657000, "total_harian": 2628000, "biaya_akomodasi": 500000, "total_akomodasi": 2000000}, {"nip": "196612291990021001", "hari": 4, "nama": "ADE IMANSAH, A.Ks., M.Si", "jabatan": "Pemeriksa Transaksi Keuangan", "pangkat": "Pembina Tk.I", "golongan": "IV/b", "biaya_harian": 657000, "total_harian": 2628000, "biaya_akomodasi": 500000, "total_akomodasi": 2000000}, {"nip": "196203211993021001", "hari": 4, "nama": "Ir.RUDY", "jabatan": "Pengawas Pemerintahan Madya", "pangkat": "Pembina Utama Muda", "golongan": "IV/c", "biaya_harian": 657000, "total_harian": 2628000, "biaya_akomodasi": 500000, "total_akomodasi": 2000000}]',
                'total_harian' => 7884000,
                'total_akomodasi' => 6000000,
                'total_transportasi' => '{"jenis": "Travel", "liter": 0, "total": "2000000"}',
                'created_at' => '2020-03-17 16:22:03',
                'updated_at' => '2020-03-17 09:22:03',
            ),
        ));
        
        
    }
}