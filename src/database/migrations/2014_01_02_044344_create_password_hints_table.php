<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordHintsTable extends Migration {

/**
 * Run the migrations.
 *
 * @return void
 */
	public function up()
	{
		Schema::create('password_hints', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->integer('user_id', 11);

			$table->string('hint');

			$table->softDeletes();
			$table->timestamp('created_at');
		});
	}

/**
 * Reverse the migrations.
 *
 * @return void
 */
	public function down()
	{
		Schema::drop('password_hints');
	}

}