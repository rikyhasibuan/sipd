<?php

use Illuminate\Database\Seeder;

class KabkotaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('kabkota')->delete();
        
        \DB::table('kabkota')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nama_kabkota' => 'Kota Bandung',
            ),
            1 => 
            array (
                'id' => 2,
                'nama_kabkota' => 'Kota Cimahi',
            ),
            2 => 
            array (
                'id' => 3,
                'nama_kabkota' => 'Kabupaten Bandung Barat',
            ),
            3 => 
            array (
                'id' => 4,
                'nama_kabkota' => 'Kabupaten Bandung',
            ),
            4 => 
            array (
                'id' => 5,
                'nama_kabkota' => 'Kabupaten Sumedang',
            ),
            5 => 
            array (
                'id' => 6,
                'nama_kabkota' => 'Kabupaten Subang',
            ),
            6 => 
            array (
                'id' => 7,
                'nama_kabkota' => 'Kabupaten Garut',
            ),
            7 => 
            array (
                'id' => 8,
                'nama_kabkota' => 'Kabupaten Cianjur',
            ),
            8 => 
            array (
                'id' => 9,
                'nama_kabkota' => 'Kabupaten Purwakarta',
            ),
            9 => 
            array (
                'id' => 10,
                'nama_kabkota' => 'Kabupaten Majalengka',
            ),
            10 => 
            array (
                'id' => 11,
                'nama_kabkota' => 'Kota Sukabumi',
            ),
            11 => 
            array (
                'id' => 12,
                'nama_kabkota' => 'Kota Tasikmalaya',
            ),
            12 => 
            array (
                'id' => 13,
                'nama_kabkota' => 'Kabupaten Karawang',
            ),
            13 => 
            array (
                'id' => 14,
                'nama_kabkota' => 'Kabupaten Bekasi',
            ),
            14 => 
            array (
                'id' => 15,
                'nama_kabkota' => 'Kabupaten Ciamis',
            ),
            15 => 
            array (
                'id' => 16,
                'nama_kabkota' => 'Kabupaten Tasikmalaya',
            ),
            16 => 
            array (
                'id' => 17,
                'nama_kabkota' => 'Kota Bogor',
            ),
            17 => 
            array (
                'id' => 18,
                'nama_kabkota' => 'Kota Bekasi',
            ),
            18 => 
            array (
                'id' => 19,
                'nama_kabkota' => 'Kota Banjar',
            ),
            19 => 
            array (
                'id' => 20,
                'nama_kabkota' => 'Kabupaten Bogor',
            ),
            20 => 
            array (
                'id' => 21,
                'nama_kabkota' => 'Kabupaten Sukabumi',
            ),
            21 => 
            array (
                'id' => 22,
                'nama_kabkota' => 'Kota Depok',
            ),
            22 => 
            array (
                'id' => 23,
                'nama_kabkota' => 'Kabupaten Kuningan',
            ),
            23 => 
            array (
                'id' => 24,
                'nama_kabkota' => 'Kabupaten Indramayu',
            ),
            24 => 
            array (
                'id' => 25,
                'nama_kabkota' => 'Kota Cirebon',
            ),
            25 => 
            array (
                'id' => 26,
                'nama_kabkota' => 'Kabupaten Cirebon',
            ),
            26 => 
            array (
                'id' => 27,
                'nama_kabkota' => 'Kabupaten Pangandaran',
            ),
            27 => 
            array (
                'id' => 28,
                'nama_kabkota' => 'DKI Jakarta',
            ),
        ));
        
        
    }
}