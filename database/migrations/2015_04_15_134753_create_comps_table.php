<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('comps', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title');
            $table->char('preview_type' , 1);
            $table->char('voting_type', 1);
            $table->text('preview_link');
            $table->text('stem_link');
            $table->timestamp('subm_end_date');
            $table->timestamp('comp_end_date');
            $table->text('header_img');
            $table->string('song_title');
            $table->string('genre')->nullable();
            $table->string('bpm')->nullable();
            $table->text('description');
            $table->text('rules');
            $table->text('prizes');
            $table->text('url')->nullable();
            $table->text('facebook')->nullable();
            $table->text('twitter')->nullable();
            $table->char('status', 1)->default('a');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::drop('comps');
	}

}
