<?php

use Illuminate\Database\Migrations\Migration;

class CreateChoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('choices', function($table) {
			$table->increments('id');
			$table->integer('poll_id')->unsigned();
			$table->string('name');
			$table->timestamps();

			$table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('choices');
	}

}