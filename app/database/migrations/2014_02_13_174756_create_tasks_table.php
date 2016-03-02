<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTasksTable extends Migration {

	public function up()
	{
		Schema::create('tasks', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title');
			$table->string('description');
			$table->decimal('hours_completed');
			$table->decimal('hours_left');
			$table->datetime('started_at');
			$table->datetime('completed_at');
			$table->integer('project_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('tasks');
	}
}