<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

/**
 * Run the migrations.
 *
 * @return void
 */
	public function up()
	{
	// Creates the users table
		Schema::create('users', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->string('email')->unique()->index();
			$table->string('username')->unique()->index();
			$table->string('password');
			$table->string('confirmation_code');
			$table->boolean('confirmed')->default(0);

			$table->timestamp('last_login');

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
		Schema::drop('users');
	}

}
