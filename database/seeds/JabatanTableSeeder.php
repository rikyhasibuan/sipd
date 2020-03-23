<?php

use Illuminate\Database\Seeder;

class JabatanTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('jabatan')->delete();
        
        \DB::table('jabatan')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nama_jabatan' => 'Analis Laporan Hasil Pengawasan',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            1 => 
            array (
                'id' => 2,
                'nama_jabatan' => 'Analis Laporan Keuangan',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            2 => 
            array (
                'id' => 3,
                'nama_jabatan' => 'Analis Perencanaan, Evaluasi dan Pelaporan',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            3 => 
            array (
                'id' => 4,
                'nama_jabatan' => 'Bendahara',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            4 => 
            array (
                'id' => 5,
                'nama_jabatan' => 'Inspektur',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            5 => 
            array (
                'id' => 6,
                'nama_jabatan' => 'Inspektur Pembantu Bidang Administrasi',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            6 => 
            array (
                'id' => 7,
                'nama_jabatan' => 'Inspektur Pembantu Bidang Khusus',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            7 => 
            array (
                'id' => 8,
                'nama_jabatan' => 'Inspektur Pembantu Bidang Pemerintahan dan Kesejahteraan Masyarakat',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            8 => 
            array (
                'id' => 9,
                'nama_jabatan' => 'Inspektur Pembantu Bidang Perekonomian dan Pembangunan',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            9 => 
            array (
                'id' => 10,
                'nama_jabatan' => 'Kepala Sub Bagian Kepegawaian dan Umum',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            10 => 
            array (
                'id' => 11,
                'nama_jabatan' => 'Kepala Sub Bagian Keuangan dan Aset',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            11 => 
            array (
                'id' => 12,
                'nama_jabatan' => 'Kepala Sub Bagian Perencanaan dan Pelaporan',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            12 => 
            array (
                'id' => 13,
                'nama_jabatan' => 'Pengadministrasi Keuangan',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            13 => 
            array (
                'id' => 14,
                'nama_jabatan' => 'Pengadministrasi Perencanaan dan Program',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            14 => 
            array (
                'id' => 15,
                'nama_jabatan' => 'Pengadministrasi Umum',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            15 => 
            array (
                'id' => 16,
                'nama_jabatan' => 'Pengelola Evaluasi Tindak Lanjut Laporan Hasil Pemeriksaan',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            16 => 
            array (
                'id' => 17,
                'nama_jabatan' => 'Pengelola Gaji',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            17 => 
            array (
                'id' => 18,
                'nama_jabatan' => 'Pengelola Keuangan',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            18 => 
            array (
                'id' => 19,
                'nama_jabatan' => 'Pengolah Data Perencanaan dan Penganggaran',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            19 => 
            array (
                'id' => 20,
                'nama_jabatan' => 'Perencana Pertama',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            20 => 
            array (
                'id' => 21,
                'nama_jabatan' => 'Sekretaris',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            21 => 
            array (
                'id' => 22,
                'nama_jabatan' => 'Verifikatur',
                'created_at' => '2020-02-01 17:51:39',
                'updated_at' => '2020-02-01 17:51:39',
            ),
            22 => 
            array (
                'id' => 23,
                'nama_jabatan' => 'Analis Sumber Daya Manusia Aparatur',
                'created_at' => '2020-02-28 01:26:19',
                'updated_at' => '2020-02-28 01:26:19',
            ),
            23 => 
            array (
                'id' => 24,
                'nama_jabatan' => 'Auditor Madya',
                'created_at' => '2020-02-28 01:26:19',
                'updated_at' => '2020-02-28 01:26:19',
            ),
            24 => 
            array (
                'id' => 25,
                'nama_jabatan' => 'Auditor Muda',
                'created_at' => '2020-02-28 01:26:19',
                'updated_at' => '2020-02-28 01:26:19',
            ),
            25 => 
            array (
                'id' => 26,
                'nama_jabatan' => 'Auditor Pelaksana Lanjutan',
                'created_at' => '2020-02-28 01:26:19',
                'updated_at' => '2020-02-28 01:26:19',
            ),
            26 => 
            array (
                'id' => 27,
                'nama_jabatan' => 'Auditor Penyelia',
                'created_at' => '2020-02-28 01:26:19',
                'updated_at' => '2020-02-28 01:26:19',
            ),
            27 => 
            array (
                'id' => 28,
                'nama_jabatan' => 'Auditor Pertama',
                'created_at' => '2020-02-28 01:26:19',
                'updated_at' => '2020-02-28 01:26:19',
            ),
            28 => 
            array (
                'id' => 29,
                'nama_jabatan' => 'Pemeriksa Transaksi Keuangan',
                'created_at' => '2020-02-28 01:26:19',
                'updated_at' => '2020-02-28 01:26:19',
            ),
            29 => 
            array (
                'id' => 30,
                'nama_jabatan' => 'Pengawas Pemerintahan Madya',
                'created_at' => '2020-02-28 01:26:19',
                'updated_at' => '2020-02-28 01:26:19',
            ),
            30 => 
            array (
                'id' => 31,
                'nama_jabatan' => 'Pengawas Pemerintahan Muda',
                'created_at' => '2020-02-28 01:26:19',
                'updated_at' => '2020-02-28 01:26:19',
            ),
            31 => 
            array (
                'id' => 32,
                'nama_jabatan' => 'Pengelola Barang Milik Negara',
                'created_at' => '2020-02-28 01:26:19',
                'updated_at' => '2020-02-28 01:26:19',
            ),
            32 => 
            array (
                'id' => 33,
            'nama_jabatan' => 'Pengelola Barang Milik Negara (Penyimpan Barang)',
                'created_at' => '2020-02-28 01:26:19',
                'updated_at' => '2020-02-28 01:26:19',
            ),
            33 => 
            array (
                'id' => 34,
                'nama_jabatan' => 'Pengelola Kepegawaian',
                'created_at' => '2020-02-28 01:26:19',
                'updated_at' => '2020-02-28 01:26:19',
            ),
            34 => 
            array (
                'id' => 35,
                'nama_jabatan' => 'Pengemudi',
                'created_at' => '2020-02-28 01:26:19',
                'updated_at' => '2020-02-28 01:26:19',
            ),
        ));
        
        
    }
}