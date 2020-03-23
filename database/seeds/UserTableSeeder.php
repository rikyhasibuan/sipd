<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user')->delete();
        
        \DB::table('user')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nip' => 'admin',
                'password' => '21232f297a57a5a743894a0e4a801fc3',
                'level_id' => 1,
                'created_at' => '2020-01-26 18:07:27',
                'updated_at' => '2020-01-26 18:07:27',
            ),
        ));
        
        
    }
}