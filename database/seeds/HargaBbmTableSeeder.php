<?php

use Illuminate\Database\Seeder;

class HargaBbmTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('harga_bbm')->delete();
        
        \DB::table('harga_bbm')->insert(array (
            0 => 
            array (
                'id' => 1,
                'harga_perliter' => 9000,
            ),
        ));
        
        
    }
}