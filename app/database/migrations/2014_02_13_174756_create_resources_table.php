<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResourcesTable extends Migration {

	public function up()
	{
		Schema::create('resources', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('initials');
		});
	}

	public function down()
	{
		Schema::drop('resources');
	}
}