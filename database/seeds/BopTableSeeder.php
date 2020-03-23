<?php

use Illuminate\Database\Seeder;

class BopTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('bop')->delete();
        
        \DB::table('bop')->insert(array (
            0 => 
            array (
                'id' => 1,
                'jabatan' => 'Penanggungjawab/Pengendali Mutu',
                'biaya_per_hari' => 1700000,
                'created_at' => '2020-02-27 18:04:08',
                'updated_at' => '2020-02-27 11:04:08',
            ),
            1 => 
            array (
                'id' => 2,
                'jabatan' => 'Wakil Penanggungjawab/Suvervisi',
                'biaya_per_hari' => 1600000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'jabatan' => 'Pengendali Teknis',
                'biaya_per_hari' => 1500000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'jabatan' => 'Ketua Tim',
                'biaya_per_hari' => 1400000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'jabatan' => 'Anggota Tim',
                'biaya_per_hari' => 1300000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'jabatan' => 'Penunjang Operasional Pengawasan',
                'biaya_per_hari' => 1400000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
            'jabatan' => 'Penunjang Administrasi Kesekretariatan (Gol. III)',
                'biaya_per_hari' => 1150000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
            'jabatan' => 'Penunjang Administrasi Kesekretariatan (Gol. I/II)',
                'biaya_per_hari' => 850000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}