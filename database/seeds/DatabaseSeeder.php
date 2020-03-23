<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AkomodasiTableSeeder::class);
        $this->call(BelanjaTableSeeder::class);
        $this->call(HarianTableSeeder::class);
        $this->call(JabatanTableSeeder::class);
        $this->call(KabkotaTableSeeder::class);
        $this->call(KegiatanTableSeeder::class);
        $this->call(LevelTableSeeder::class);
        $this->call(PangkatTableSeeder::class);
        $this->call(PegawaiTableSeeder::class);
        $this->call(ProgramTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(AnggaranTableSeeder::class);
        $this->call(BbmTableSeeder::class);
        $this->call(BopTableSeeder::class);
        $this->call(DinasbopTableSeeder::class);
        $this->call(DinasbopTimTableSeeder::class);
        $this->call(DinasregularTableSeeder::class);
        $this->call(HargaBbmTableSeeder::class);
        $this->call(IrbanTableSeeder::class);
        $this->call(IrbanKabkotaTableSeeder::class);
        $this->call(IrbanPokjaTableSeeder::class);
        $this->call(IrbanSkpdTableSeeder::class);
        $this->call(SkpdTableSeeder::class);
    }
}
