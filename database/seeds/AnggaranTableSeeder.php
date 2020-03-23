<?php

use Illuminate\Database\Seeder;

class AnggaranTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('anggaran')->delete();
        
        \DB::table('anggaran')->insert(array (
            0 => 
            array (
                'id' => 1,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 1,
                'jumlah' => 35218641,
                'bulan' => 1,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:30',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 1,
                'jumlah' => 49780573,
                'bulan' => 2,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:30',
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 1,
                'jumlah' => 80000000,
                'bulan' => 3,
                'tahun' => 2020,
                'created_at' => '2020-03-17 15:31:42',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 1,
                'jumlah' => 44649554,
                'bulan' => 4,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:31',
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 1,
                'jumlah' => 43427075,
                'bulan' => 5,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:31',
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 1,
                'jumlah' => 44607061,
                'bulan' => 6,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:31',
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 1,
                'jumlah' => 35438959,
                'bulan' => 7,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:31',
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 1,
                'jumlah' => 34115004,
                'bulan' => 8,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:31',
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 1,
                'jumlah' => 39645265,
                'bulan' => 9,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:31',
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 1,
                'jumlah' => 48159764,
                'bulan' => 10,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:31',
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 1,
                'jumlah' => 34929163,
                'bulan' => 11,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:31',
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 1,
                'jumlah' => 30634659,
                'bulan' => 12,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:31',
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 2,
                'jumlah' => 50000000,
                'bulan' => 1,
                'tahun' => 2020,
                'created_at' => '2020-03-17 08:39:37',
                'updated_at' => '2020-03-17 08:39:37',
            ),
            13 => 
            array (
                'id' => 14,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 2,
                'jumlah' => 49780573,
                'bulan' => 2,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:30',
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 2,
                'jumlah' => 80000000,
                'bulan' => 3,
                'tahun' => 2020,
                'created_at' => '2020-03-17 15:31:42',
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 2,
                'jumlah' => 44649554,
                'bulan' => 4,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:31',
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 2,
                'jumlah' => 43427075,
                'bulan' => 5,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:31',
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 2,
                'jumlah' => 44607061,
                'bulan' => 6,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:31',
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 2,
                'jumlah' => 35438959,
                'bulan' => 7,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:31',
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 2,
                'jumlah' => 34115004,
                'bulan' => 8,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:31',
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 2,
                'jumlah' => 39645265,
                'bulan' => 9,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:31',
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 2,
                'jumlah' => 48159764,
                'bulan' => 10,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:31',
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 2,
                'jumlah' => 34929163,
                'bulan' => 11,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:31',
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 2,
                'jumlah' => 30634659,
                'bulan' => 12,
                'tahun' => 2020,
                'created_at' => '2020-02-03 20:19:31',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}