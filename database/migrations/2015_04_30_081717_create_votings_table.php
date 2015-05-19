<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('votings', function(Blueprint $table)
		{
			$table->increments('id');
            $table->timestamp('show_date');
            $table->char('status', 1)->default('v');
            $table->integer('comp_id')->unsigned();
            $table->foreign('comp_id')
                ->references('id')
                ->on('comps')
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
		Schema::drop('votings');
	}

}
