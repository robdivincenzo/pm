<?php

class TasksController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// get all tasks
		$tasks = DB::table('tasks')
		                     ->select(DB::raw('
		                     		tasks.*, 
		                     		max(resource_task.due_at) as due_at, 
		                     		sum(resource_task.hours_estimate) as hours_estimate, 
		                     		(CASE WHEN min(resource_task.completed) <> 0 THEN "Yes" ELSE "No" END) as completed'
		                     	))
		                     ->leftJoin('resource_task', 'tasks.id', '=', 'resource_task.task_id')
		                     ->where('resource_task.completed', '=', 'No')
		                     ->groupBy('resource_task.task_id')
		                     ->get();

		// load the view and pass the tasks to it
		return View::make('tasks.index')
			->with('tasks', $tasks);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$project_list = Project::orderBy('title')->lists('title', 'id');
		$resource_list = Resource::orderBy('initials')->lists('initials', 'id');
		return View::make('tasks.create')
			->with(	
				array( 
					'project_list' => $project_list,
					'resource_list' => $resource_list
					)
				);
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
			'project_id' => 'required|numeric',
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('tasks/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$task = new Task;
			$task->title = Input::get('title');
			$task->description = Input::get('description');
			$task->project_id = Input::get('project_id');
			$task->save();
			//store any resource linking
			$resource_ids = Input::get('resource_ids');
			$hours_estimates = Input::get('hours_estimates');
			$due_at = Input::get('due_at');
			foreach( $resource_ids as $key => $resource_id ) {
				$resource_task = new Resource_task;
				$resource_task->resource_id = $resource_id;
				$resource_task->task_id = $task->id;
				$resource_task->hours_estimate = $hours_estimates[$key];
				$resource_task->due_at = $due_at[$key];
				$resource_task->save();
			}
			// redirect
			Session::flash('message', 'Successfully created task');
			return Redirect::to('tasks');
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
		// get the task
		$task = DB::table('tasks')
		                     ->select(DB::raw('tasks.*, sum(resource_task.hours_estimate) as hours_estimate'))
		                     ->where('tasks.id', '=', $id)
		                     ->join('resource_task', 'resource_task.task_id', '=', 'tasks.id')
		                     ->groupBy('resource_task.task_id')
		                     ->first();
		// get the resources
		$resources = DB::table('resources')
							 ->select(DB::raw('resources.*, resource_task.*, (CASE WHEN resource_task.completed <> 0 THEN "Yes" ELSE "No" END) as completed'))
		                     ->leftJoin('resource_task', 'resources.id', '=', 'resource_task.resource_id')
		                     ->where('resource_task.task_id', '=', $id)
		                     ->get();

		// show the view and pass the task to it
		return View::make('tasks.show')
			->with( 
				array( 
					'task' => $task, 
					'resources' => $resources 
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
		// get the task
		$task = DB::table('tasks')
							->select('tasks.*', 'resource_task.id as resource_task_id', 'resource_id as resource_id', 'resource_task.completed as completed', 'resource_task.hours_estimate as hours_estimate')
		                    ->where('tasks.id', '=', $id)
		                    ->leftJoin('resource_task', 'tasks.id', '=', 'resource_task.task_id')
		                    ->first();
		$project_list = Project::orderBy('title')->lists('title', 'id');
		$resource_list = Resource::orderBy('initials')->lists('initials','id');
		$resource_tasks = Resource_task::where('task_id', $id)->join('resources','resources.id','=','resource_id')->orderBy('resources.initials')->get();

		// show the edit form and pass the nerd
		return View::make('tasks.edit')
			->with( 
				array( 
					'task' => $task,
					'project_list' => $project_list,
					'resource_tasks' => $resource_tasks,
					'resource_list' => $resource_list
					)
				);
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
			return Redirect::to('tasks/' . $id . '/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$task = Task::find($id);
			$task->title = Input::get('title');
			$task->description = Input::get('description');
			$task->project_id = Input::get('project_id');
			$task->save();
			$completed = Input::get('completed');
			//remove any old resource linking
			$old_resource_task = Resource_task::where('task_id', '=', $id)->delete();
			//store any resource_task linking
			$resource_ids = Input::get('resource_ids');
			$hours_estimates = Input::get('hours_estimates');
			$due_at = Input::get('due_at');
			if( $resource_ids !='' ) {
				foreach( $resource_ids as $key => $resource_id ) {
					$resource_task = new Resource_task;
					$resource_task->resource_id = $resource_id;
					$resource_task->task_id = $task->id;
					$resource_task->hours_estimate = $hours_estimates[$key];
					$resource_task->due_at = $due_at[$key];
					$resource_task->completed = $completed[$key];
					$resource_task->save();
				}
			}
			// redirect
			// redirect
			Session::flash('message', 'Successfully updated task');
			return Redirect::to('tasks');
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
		$task = Task::find($id);
		$task->delete();

		// redirect
		Session::flash('message', 'Successfully deleted the task');
		return Redirect::to('tasks');
	}

}