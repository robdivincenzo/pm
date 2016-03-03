<?php

namespace App\Http\Controllers;
use DB;
use Resource;
use Validator;
use Input;
use Session;
use Redirect;

class ResourcesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct()
    {
        $this->middleware('web');
    }
	
	public function index()
	{
		// get all resources
		$resources = Resource::all();

		// load the view and pass the resources to it
		return view('resources.index', ['resources' => $resources] );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('resources.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'initials' => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('resources/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$resource = new Resource;
			$resource->initials = Input::get('initials');
			$resource->save();

			// redirect
			Session::flash('message', 'Successfully created resource!');
			return Redirect::to('resources');
		}

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// get the resource
		$resource = Resource::find($id);
		// get the task
		$tasks = DB::table('tasks')
		                     ->select(DB::raw('tasks.*, resource_task.hours_estimate'))
		                     ->where('resource_task.resource_id', '=', $id)
		                     ->join('resource_task', 'resource_task.task_id', '=', 'tasks.id')
//		                     ->groupBy('resource_task.task_id')
		                     ->get();

		// show the view and pass the resource to it
		return view('resources.show', [
			'resource' => $resource,
			'tasks' => $tasks,
				]
			);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// get the resource
		$resource = Resource::find($id);

		// show the edit form and pass the resource
		return view('resources.edit', ['resource' => $resource]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'initials' => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('resources/' . $id . '/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$resource = Resource::find($id);
			$resource->initials = Input::get('initials');
			$resource->save();

			// redirect
			Session::flash('message', 'Successfully updated resource');
			return Redirect::to('resources');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// delete
		$resource = Resource::find($id);
		$resource->delete();

		// redirect
		Session::flash('message', 'Successfully deleted the resource');
		return Redirect::to('resources');
	}

}