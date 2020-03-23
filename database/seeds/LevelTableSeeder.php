<?php

use Illuminate\Database\Seeder;

class LevelTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('level')->delete();
        
        \DB::table('level')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nama_level' => 'Administrator',
            ),
            1 => 
            array (
                'id' => 2,
                'nama_level' => 'Operator',
            ),
            2 => 
            array (
                'id' => 5,
                'nama_level' => 'Manajemen',
            ),
        ));
        
        
    }
}