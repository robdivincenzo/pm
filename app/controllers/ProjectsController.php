<?php

class ProjectsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// get all projects
		$projects = DB::table('projects')
		                     ->select(DB::raw('projects.*, sum(resource_task.hours_estimate) as hours_estimate'))
		                     ->leftJoin('tasks', 'projects.id', '=', 'tasks.project_id')
		                     ->leftJoin('resource_task', 'tasks.id', '=', 'resource_task.task_id')
		                     ->groupBy('projects.id')
		                     ->get();

		// load the view and pass the projects to it
		return View::make('projects.index')
			->with('projects', $projects);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('projects.create');
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
			'title'       => 'required',
			'description'      => '',
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('projects/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$project = new Project;
			$project->title = Input::get('title');
			$project->description = Input::get('description');
			$project->save();

			// redirect
			Session::flash('message', 'Successfully created project');
			return Redirect::to('projects');
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
		// get the project
		$project = Project::find($id);
		$tasks = DB::table('tasks')
		                     ->select(DB::raw('tasks.*, max(resource_task.due_at) as due_at, sum(resource_task.hours_estimate) as hours_estimate'))
		                     ->where('projects.id', '=', $id)
		                     ->leftJoin('resource_task', 'tasks.id', '=', 'resource_task.task_id')
		                     ->leftJoin('projects', 'tasks.project_id', '=', 'projects.id')
		                     ->groupBy('resource_task.task_id')
		                     ->get();
		// show the view and pass the project to it
		return View::make('projects.show')
			->with( 
				array( 
					'project'=> $project,
					'tasks' => $tasks 
					)
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
		// get the project
		$project = Project::find($id);

		// show the edit form and pass the nerd
		return View::make('projects.edit')
			->with('project', $project);
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
			'title'       => 'required',
			'description'      => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('projects/' . $id . '/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$project = Project::find($id);
			$project->title = Input::get('title');
			$project->description = Input::get('description');
			$project->save();

			// redirect
			Session::flash('message', 'Successfully updated project');
			return Redirect::to('projects');
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
		$project = Project::find($id);
		$project->delete();

		// redirect
		Session::flash('message', 'Successfully deleted the project');
		return Redirect::to('projects');
	}

}