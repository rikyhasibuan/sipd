<?php

use Illuminate\Database\Seeder;

class ProgramTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('program')->delete();
        
        \DB::table('program')->insert(array (
            0 => 
            array (
                'id' => 1,
                'kode_program' => '3.05.262',
                'nama_program' => 'Peningkatan Sistem Pengendalian Intern dan Integritas',
                'created_at' => '2020-01-21 17:52:42',
                'updated_at' => '2020-01-21 17:52:42',
            ),
            1 => 
            array (
                'id' => 2,
                'kode_program' => '3.05.264',
                'nama_program' => 'Peningkatan Kapabilitas APIP',
                'created_at' => '2020-01-21 17:52:55',
                'updated_at' => '2020-01-21 17:52:55',
            ),
            2 => 
            array (
                'id' => 3,
                'kode_program' => '3.05.265',
                'nama_program' => 'Peningkatan Kualitas Akuntabilitas Kinerja',
                'created_at' => '2020-01-21 17:53:06',
                'updated_at' => '2020-01-21 17:53:06',
            ),
            3 => 
            array (
                'id' => 4,
                'kode_program' => '3.05.266',
                'nama_program' => 'Peningkatan Kualitas Pengelolaan Keuangan Daerah',
                'created_at' => '2020-01-21 17:53:22',
                'updated_at' => '2020-01-21 17:53:22',
            ),
            4 => 
            array (
                'id' => 5,
                'kode_program' => '3.05.267',
                'nama_program' => 'Peningkatan Kualitas Penyelenggaraan Urusan Pemerintahan Daerah',
                'created_at' => '2020-01-21 17:53:35',
                'updated_at' => '2020-01-21 17:53:35',
            ),
        ));
        
        
    }
}