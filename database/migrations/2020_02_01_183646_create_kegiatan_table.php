<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKegiatanTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kegiatan', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('program_id')->nullable()->index('program_id');
			$table->string('bendahara')->nullable();
			$table->string('kode_kegiatan');
			$table->string('nama_kegiatan');
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
		Schema::drop('kegiatan');
	}

}
