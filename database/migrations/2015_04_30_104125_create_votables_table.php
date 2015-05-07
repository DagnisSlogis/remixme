<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('votables', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('slug');
            $table->integer('votes')->default('0');
            $table->integer('submition_id')->unsigned();
            $table->foreign('submition_id')
                ->references('id')
                ->on('submitions')
                ->onDelete('cascade');
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
		Schema::drop('votables');
	}

}
