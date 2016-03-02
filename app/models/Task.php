<?php

class Task extends Eloquent {

	protected $table = 'tasks';
	public $timestamps = true;
	protected $softDelete = false;

	public function project()
	{
		return $this->belongsTo('Project');
	}

	public function resources()
	{
		return $this->belongsToMany('Resource');
	}
	
}