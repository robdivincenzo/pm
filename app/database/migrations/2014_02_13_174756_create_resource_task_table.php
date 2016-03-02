<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResourceTaskTable extends Migration {

	public function up()
	{
		Schema::create('resource_task', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('resource_id')->unsigned();
			$table->integer('task_id')->unsigned();
			$table->decimal('hours_estimate');
			$table->date('due_at');
			$table->boolean('completed');
		});
	}

	public function down()
	{
		Schema::drop('resource_task');
	}
}