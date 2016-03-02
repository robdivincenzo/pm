<?php

class Project extends Eloquent {

	protected $table = 'projects';
	public $timestamps = true;
	protected $softDelete = false;

	public function tasks()
	{
		return $this->hasMany('Task');
	}

}