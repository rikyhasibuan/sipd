<?php

use Illuminate\Database\Seeder;

class PangkatTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pangkat')->delete();
        
        \DB::table('pangkat')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nama_pangkat' => 'Pembina Utama Madya',
                'created_at' => '2020-02-01 17:47:56',
                'updated_at' => '2020-02-01 17:47:56',
            ),
            1 => 
            array (
                'id' => 2,
                'nama_pangkat' => 'Pembina Tk. I',
                'created_at' => '2020-02-01 17:47:56',
                'updated_at' => '2020-02-01 17:47:56',
            ),
            2 => 
            array (
                'id' => 3,
                'nama_pangkat' => 'Pembina',
                'created_at' => '2020-02-01 17:47:56',
                'updated_at' => '2020-02-01 17:47:56',
            ),
            3 => 
            array (
                'id' => 4,
                'nama_pangkat' => 'Penata Tk.I',
                'created_at' => '2020-02-01 17:47:56',
                'updated_at' => '2020-02-01 17:47:56',
            ),
            4 => 
            array (
                'id' => 5,
                'nama_pangkat' => 'Penata',
                'created_at' => '2020-02-01 17:47:56',
                'updated_at' => '2020-02-01 17:47:56',
            ),
            5 => 
            array (
                'id' => 6,
                'nama_pangkat' => 'Penata Muda Tk.I',
                'created_at' => '2020-02-01 17:47:56',
                'updated_at' => '2020-02-01 17:47:56',
            ),
            6 => 
            array (
                'id' => 7,
                'nama_pangkat' => 'Penata Muda',
                'created_at' => '2020-02-01 17:47:56',
                'updated_at' => '2020-02-01 17:47:56',
            ),
            7 => 
            array (
                'id' => 8,
                'nama_pangkat' => 'Pengatur Muda Tk.I',
                'created_at' => '2020-02-01 17:47:56',
                'updated_at' => '2020-02-01 17:47:56',
            ),
            8 => 
            array (
                'id' => 9,
                'nama_pangkat' => 'Pengatur Muda',
                'created_at' => '2020-02-01 17:47:56',
                'updated_at' => '2020-02-01 17:47:56',
            ),
            9 => 
            array (
                'id' => 10,
                'nama_pangkat' => 'Pengatur Tk.I',
                'created_at' => '2020-02-01 17:47:56',
                'updated_at' => '2020-02-01 17:47:56',
            ),
            10 => 
            array (
                'id' => 11,
                'nama_pangkat' => 'Pengatur',
                'created_at' => '2020-02-01 17:47:56',
                'updated_at' => '2020-02-01 17:47:56',
            ),
            11 => 
            array (
                'id' => 12,
                'nama_pangkat' => 'Juru Tk.I',
                'created_at' => '2020-02-01 17:47:56',
                'updated_at' => '2020-02-01 17:47:56',
            ),
            12 => 
            array (
                'id' => 13,
                'nama_pangkat' => 'Juru Muda Tk.I',
                'created_at' => '2020-02-01 17:47:56',
                'updated_at' => '2020-02-01 17:47:56',
            ),
            13 => 
            array (
                'id' => 14,
                'nama_pangkat' => 'Pembina Utama Muda',
                'created_at' => '2020-02-01 17:47:56',
                'updated_at' => '2020-02-01 17:47:56',
            ),
            14 => 
            array (
                'id' => 15,
                'nama_pangkat' => 'Pembina Tk.I',
                'created_at' => '2020-02-01 17:47:56',
                'updated_at' => '2020-02-01 17:47:56',
            ),
            15 => 
            array (
                'id' => 16,
                'nama_pangkat' => 'Pembina',
                'created_at' => '2020-02-01 17:47:56',
                'updated_at' => '2020-02-01 17:47:56',
            ),
        ));
        
        
    }
}