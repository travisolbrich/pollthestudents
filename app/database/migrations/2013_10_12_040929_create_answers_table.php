<?php

use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('answers', function($table)
		{
			$table->increments('id');
			$table->integer('poll_id')->unsigned();
			$table->integer('choice_id')->unsigned();
			$table->timestamps();

			$table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade');
			$table->foreign('choice_id')->references('id')->on('choices');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('answers');
	}

}