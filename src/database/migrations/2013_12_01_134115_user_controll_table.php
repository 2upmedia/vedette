<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UserControllTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('user_controlls', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->integer('user_id', 11);

			$table->string('ip_address')->nullable();

			$table->smallInteger('attempts', 1)->nullable();
			$table->smallInteger('suspended', 1)->nullable();
			$table->smallInteger('banned', 1)->nullable();

			$table->timestamp('last_attempt_at');
			$table->timestamp('suspended_at');
			$table->timestamp('banned_at');

			$table->softDeletes();
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
		Schema::drop('environs_usage_types');
	}

}