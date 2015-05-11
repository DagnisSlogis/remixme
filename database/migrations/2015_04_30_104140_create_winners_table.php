<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWinnersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('winners', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('voting_id')->unsigned();
            $table->foreign('voting_id')
                ->references('id')
                ->on('votings')
                ->onDelete('cascade');
            $table->integer('submition_id')->unsigned();
            $table->foreign('submition_id')
                ->references('id')
                ->on('submitions')
                ->onDelete('cascade');
            $table->integer('place');
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
		Schema::drop('winners');
	}

}
