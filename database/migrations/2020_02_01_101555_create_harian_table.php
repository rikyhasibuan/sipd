<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHarianTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('harian', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('kabkota_id')->index('kabkota_id');
			$table->integer('gol_1');
			$table->integer('gol_2');
			$table->integer('gol_3');
			$table->integer('gol_4');
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
		Schema::drop('harian');
	}

}
