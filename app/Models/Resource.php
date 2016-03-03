<?php

class Resource extends Eloquent {

	protected $table = 'resources';
	public $timestamps = true;
	protected $softDelete = false;

	public function tasks()
	{
		return $this->belongsToMany('Task');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

}