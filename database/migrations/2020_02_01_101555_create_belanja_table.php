<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBelanjaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('belanja', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('program_id')->index('program_id');
			$table->integer('kegiatan_id')->index('kegiatan_id');
			$table->string('kode_belanja');
			$table->string('nama_belanja');
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
		Schema::drop('belanja');
	}

}
