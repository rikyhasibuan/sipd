<?php

use Illuminate\Database\Seeder;

class IrbanTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('irban')->delete();
        
        \DB::table('irban')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nama_irban' => 'Bidang Pemerintahan dan Kesejahteraan Masyarakat',
                'created_at' => '2019-07-13 12:13:34',
                'updated_at' => '2019-07-13 12:14:22',
            ),
            1 => 
            array (
                'id' => 2,
                'nama_irban' => 'Bidang Perekonomian dan Pembangunan',
                'created_at' => '2019-07-13 12:13:51',
                'updated_at' => '2019-07-13 12:14:22',
            ),
            2 => 
            array (
                'id' => 3,
                'nama_irban' => 'Bidang Administrasi',
                'created_at' => '2019-07-13 12:14:04',
                'updated_at' => '2019-07-13 12:14:22',
            ),
            3 => 
            array (
                'id' => 4,
                'nama_irban' => 'Bidang Khusus',
                'created_at' => '2019-07-13 12:14:11',
                'updated_at' => '2019-07-13 12:14:22',
            ),
        ));
        
        
    }
}