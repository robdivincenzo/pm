<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('tasks', function(Blueprint $table) {
			$table->foreign('project_id')->references('id')->on('projects')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('resource_task', function(Blueprint $table) {
			$table->foreign('resource_id')->references('id')->on('resources')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('resource_task', function(Blueprint $table) {
			$table->foreign('task_id')->references('id')->on('tasks')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('tasks', function(Blueprint $table) {
			$table->dropForeign('tasks_project_id_foreign');
		});
		Schema::table('resource_task', function(Blueprint $table) {
			$table->dropForeign('resource_task_resource_id_foreign');
		});
		Schema::table('resource_task', function(Blueprint $table) {
			$table->dropForeign('resource_task_task_id_foreign');
		});
	}
}