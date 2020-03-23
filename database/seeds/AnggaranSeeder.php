<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class AnggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for ($i = 1; $i <= 12; $i++) {
            DB::table('anggaran')->insert([
                'program_id' => 1,
                'kegiatan_id' => 1,
                'belanja_id' => 1,
                'jumlah' => $faker->numberBetween(30000000, 50000000),
                'bulan' => $i,
                'tahun' => date('Y'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
