<?php

use Illuminate\Database\Seeder;

class BelanjaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('belanja')->delete();
        
        \DB::table('belanja')->insert(array (
            0 => 
            array (
                'id' => 1,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-01-29 04:58:39',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'program_id' => 1,
                'kegiatan_id' => 1,
                'kode_belanja' => '5.2.2.15.03',
                'nama_belanja' => 'Perjalanan Dinas Luar Provinsi PNS Provinsi',
                'created_at' => '2020-01-29 04:58:39',
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'program_id' => 1,
                'kegiatan_id' => 2,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-02 19:10:01',
                'updated_at' => '2020-03-02 19:10:01',
            ),
            3 => 
            array (
                'id' => 4,
                'program_id' => 1,
                'kegiatan_id' => 3,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-02 19:10:21',
                'updated_at' => '2020-03-02 19:10:21',
            ),
            4 => 
            array (
                'id' => 5,
                'program_id' => 1,
                'kegiatan_id' => 3,
                'kode_belanja' => '5.2.2.15.03',
                'nama_belanja' => 'Perjalanan Dinas Luar Provinsi PNS Provinsi',
                'created_at' => '2020-03-02 19:10:41',
                'updated_at' => '2020-03-02 19:10:41',
            ),
            5 => 
            array (
                'id' => 6,
                'program_id' => 1,
                'kegiatan_id' => 4,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-02 19:11:01',
                'updated_at' => '2020-03-02 19:11:01',
            ),
            6 => 
            array (
                'id' => 7,
                'program_id' => 2,
                'kegiatan_id' => 5,
                'kode_belanja' => '5.2.2.15.03',
                'nama_belanja' => 'Perjalanan Dinas Luar Provinsi PNS Provinsi',
                'created_at' => '2020-03-02 19:11:17',
                'updated_at' => '2020-03-02 19:11:17',
            ),
            7 => 
            array (
                'id' => 8,
                'program_id' => 2,
                'kegiatan_id' => 6,
                'kode_belanja' => '5.2.2.15.03',
                'nama_belanja' => 'Perjalanan Dinas Luar Provinsi PNS Provinsi',
                'created_at' => '2020-03-02 19:11:33',
                'updated_at' => '2020-03-02 19:11:33',
            ),
            8 => 
            array (
                'id' => 9,
                'program_id' => 2,
                'kegiatan_id' => 7,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-03 02:13:46',
                'updated_at' => '2020-03-02 19:13:46',
            ),
            9 => 
            array (
                'id' => 10,
                'program_id' => 2,
                'kegiatan_id' => 7,
                'kode_belanja' => '5.2.2.15.03',
                'nama_belanja' => 'Perjalanan Dinas Luar Provinsi PNS Provinsi',
                'created_at' => '2020-03-02 19:13:23',
                'updated_at' => '2020-03-02 19:13:23',
            ),
            10 => 
            array (
                'id' => 11,
                'program_id' => 3,
                'kegiatan_id' => 8,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-02 19:14:39',
                'updated_at' => '2020-03-02 19:14:39',
            ),
            11 => 
            array (
                'id' => 12,
                'program_id' => 3,
                'kegiatan_id' => 9,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-02 19:14:53',
                'updated_at' => '2020-03-02 19:14:53',
            ),
            12 => 
            array (
                'id' => 13,
                'program_id' => 3,
                'kegiatan_id' => 10,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-02 19:15:06',
                'updated_at' => '2020-03-02 19:15:06',
            ),
            13 => 
            array (
                'id' => 14,
                'program_id' => 4,
                'kegiatan_id' => 11,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-02 19:15:27',
                'updated_at' => '2020-03-02 19:15:27',
            ),
            14 => 
            array (
                'id' => 15,
                'program_id' => 4,
                'kegiatan_id' => 11,
                'kode_belanja' => '5.2.2.15.03',
                'nama_belanja' => 'Perjalanan Dinas Luar Provinsi PNS Provinsi',
                'created_at' => '2020-03-02 19:15:39',
                'updated_at' => '2020-03-02 19:15:39',
            ),
            15 => 
            array (
                'id' => 16,
                'program_id' => 4,
                'kegiatan_id' => 12,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-02 19:15:53',
                'updated_at' => '2020-03-02 19:15:53',
            ),
            16 => 
            array (
                'id' => 17,
                'program_id' => 4,
                'kegiatan_id' => 13,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-02 19:16:11',
                'updated_at' => '2020-03-02 19:16:11',
            ),
            17 => 
            array (
                'id' => 18,
                'program_id' => 4,
                'kegiatan_id' => 14,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-02 19:16:28',
                'updated_at' => '2020-03-02 19:16:28',
            ),
            18 => 
            array (
                'id' => 19,
                'program_id' => 4,
                'kegiatan_id' => 15,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-02 19:16:40',
                'updated_at' => '2020-03-02 19:16:40',
            ),
            19 => 
            array (
                'id' => 20,
                'program_id' => 4,
                'kegiatan_id' => 16,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-02 19:17:03',
                'updated_at' => '2020-03-02 19:17:03',
            ),
            20 => 
            array (
                'id' => 21,
                'program_id' => 4,
                'kegiatan_id' => 16,
                'kode_belanja' => '5.2.2.17.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah Non PNS',
                'created_at' => '2020-03-03 02:26:52',
                'updated_at' => '2020-03-02 19:26:52',
            ),
            21 => 
            array (
                'id' => 22,
                'program_id' => 5,
                'kegiatan_id' => 17,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-02 19:18:09',
                'updated_at' => '2020-03-02 19:18:09',
            ),
            22 => 
            array (
                'id' => 23,
                'program_id' => 5,
                'kegiatan_id' => 18,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-02 19:18:21',
                'updated_at' => '2020-03-02 19:18:21',
            ),
            23 => 
            array (
                'id' => 24,
                'program_id' => 5,
                'kegiatan_id' => 18,
                'kode_belanja' => '5.2.2.15.03',
                'nama_belanja' => 'Perjalanan Dinas Luar Provinsi PNS Provinsi',
                'created_at' => '2020-03-02 19:18:33',
                'updated_at' => '2020-03-02 19:18:33',
            ),
            24 => 
            array (
                'id' => 25,
                'program_id' => 5,
                'kegiatan_id' => 19,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-02 19:18:45',
                'updated_at' => '2020-03-02 19:18:45',
            ),
            25 => 
            array (
                'id' => 26,
                'program_id' => 5,
                'kegiatan_id' => 19,
                'kode_belanja' => '5.2.2.15.03',
                'nama_belanja' => 'Perjalanan Dinas Luar Provinsi PNS Provinsi',
                'created_at' => '2020-03-02 19:18:56',
                'updated_at' => '2020-03-02 19:18:56',
            ),
            26 => 
            array (
                'id' => 27,
                'program_id' => 5,
                'kegiatan_id' => 19,
                'kode_belanja' => '5.2.2.16.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah  PNS Non Provinsi',
                'created_at' => '2020-03-02 19:19:06',
                'updated_at' => '2020-03-02 19:19:06',
            ),
            27 => 
            array (
                'id' => 28,
                'program_id' => 5,
                'kegiatan_id' => 20,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-02 19:19:19',
                'updated_at' => '2020-03-02 19:19:19',
            ),
            28 => 
            array (
                'id' => 29,
                'program_id' => 5,
                'kegiatan_id' => 20,
                'kode_belanja' => '5.2.2.15.03',
                'nama_belanja' => 'Perjalanan Dinas Luar Provinsi PNS Provinsi',
                'created_at' => '2020-03-02 19:19:36',
                'updated_at' => '2020-03-02 19:19:36',
            ),
            29 => 
            array (
                'id' => 30,
                'program_id' => 5,
                'kegiatan_id' => 20,
                'kode_belanja' => '5.2.2.17.03',
                'nama_belanja' => 'Perjalanan Dinas Luar Provinsi Non PNS',
                'created_at' => '2020-03-02 19:19:56',
                'updated_at' => '2020-03-02 19:19:56',
            ),
            30 => 
            array (
                'id' => 31,
                'program_id' => 5,
                'kegiatan_id' => 21,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-02 19:20:34',
                'updated_at' => '2020-03-02 19:20:34',
            ),
            31 => 
            array (
                'id' => 32,
                'program_id' => 5,
                'kegiatan_id' => 22,
                'kode_belanja' => '5.2.2.15.02',
                'nama_belanja' => 'Perjalanan Dinas Dalam Daerah PNS Provinsi',
                'created_at' => '2020-03-03 02:21:36',
                'updated_at' => '2020-03-02 19:21:36',
            ),
            32 => 
            array (
                'id' => 33,
                'program_id' => 5,
                'kegiatan_id' => 22,
                'kode_belanja' => '5.2.2.15.03',
                'nama_belanja' => 'Perjalanan Dinas Luar Provinsi PNS Provinsi',
                'created_at' => '2020-03-02 19:21:53',
                'updated_at' => '2020-03-02 19:21:53',
            ),
        ));
        
        
    }
}