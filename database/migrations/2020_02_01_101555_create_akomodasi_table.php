<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAkomodasiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('akomodasi', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('kabkota_id')->index('kabkota_id');
			$table->integer('eselon_2');
			$table->integer('eselon_3');
			$table->integer('madya');
			$table->integer('eselon_4_gol_3_4');
			$table->integer('gol_1_2');
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
		Schema::drop('akomodasi');
	}

}
