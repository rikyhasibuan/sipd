<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePegawaiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pegawai', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('nip');
			$table->string('nama');
			$table->string('golongan')->nullable();
			$table->string('pangkat')->nullable();
			$table->string('jabatan')->nullable();
			$table->string('eselon')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pegawai');
	}

}
