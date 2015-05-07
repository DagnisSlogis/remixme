<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->string('type')->nullable();
            $table->string('title')->nullable();
            $table->string('subject')->nullable();
            $table->integer('comp_id')->unsigned();
            $table->foreign('comp_id')
                ->references('id')
                ->on('comps')
                ->onDelete('cascade');
            $table->boolean('is_read')->default(0);
            $table->timestamp('show_date')->nullable();
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
		Schema::drop('notifications');
	}

}
