<?php

namespace App\Http\Controllers;
use DB;
use Validator;
use Input;
use DateTime;
Use DatePeriod;
use DateInterval;

class ReportsController extends Controller {

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
		
	}
	public function workload()
	{
		$workload = array(); // initials workload
		$resources_total = array(); //initialize total per resource
		$projects_total = 0; // initialize total hours
		$custom_date = false;

		$rules = array(
			'start_date' => 'date',
			'end_date' => 'date',
			'start_of_week' => 'date',
			'start_of_week' => 'date'
		);

		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('workload')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			$start_date = Input::get('start_date');
			$end_date = Input::get('end_date');
			$start_of_week = Input::get('start_of_week');
			$get_week = Input::get('get_week');
			$start_of_week = Input::get('start_of_week');
		}
		//if dates are set
		if( $start_date != "" && $end_date != "" ) {
			$start_week = new DateTime($start_date);
			$end_week = new DateTime($end_date);
			//Add one day to include the ending day
			$end_week->add(new DateInterval('P1D'));

			$week_period = new DatePeriod(
							$start_week, 
							DateInterval::createFromDateString('+1 days'), 
							$end_week);
			$custom_date = true;
		} 
		//else, if the start of the week is set
		else if( $start_of_week != '') {
			$start_of_week = new DateTime($start_of_week);
			//print_r($start_of_week);
			//die;
			if( $get_week == 'prev') {
				$start_of_week->modify('tomorrow');
				$start_of_week->modify('last Sunday');
				$start_of_week->modify('last Sunday');
			} else if ( $get_week == 'next' ) {
				$start_of_week->modify('yesterday');
				$start_of_week->modify('next Sunday');
				$start_of_week->modify('next Sunday');
			}
			$week_period = new DatePeriod(
			    $start_of_week,
			    DateInterval::createFromDateString('+1 days'),
			    6
			);
		}
		//else, get the entire week from now
		else {
			$today= new DateTime('now');
			$today->modify('tomorrow');
			$today->modify('last Sunday');

			$week_period = new DatePeriod(
			    $today,
			    DateInterval::createFromDateString('+1 days'),
			    6
			);
		}
		//generate the week into an array
		$datetime = iterator_to_array($week_period);
		//format the week
		foreach( $datetime as $workday ) {
			$days[]=$workday->format('Y-m-d');
		}
		//Get all the projects
		$projects = DB::table('projects')
		                     ->select(DB::raw('projects.*'))
		                     ->groupBy('projects.id')
		                     ->orderBy('projects.title')
		                     ->get();
		//Get all the resources
		$resources = DB::table('resources')		                    
		                     ->orderBy('resources.initials')
		                     ->get();

		//Foreach Project
		foreach( $projects as $project ) {
			$workload[$project->id]['title'] = $project->title;
			$workload[$project->id]['id'] = $project->id;
			//Calculate the project's total hours
			$workload[$project->id]['hours_estimate'] = DB::table('projects')
		                     ->leftJoin('tasks', 'projects.id', '=', 'tasks.project_id')
		                     ->leftJoin('resource_task', 'tasks.id', '=', 'resource_task.task_id')
		                     ->groupBy('projects.id')
		                     ->orderBy('projects.title')
							 ->where('tasks.project_id', $project->id)
 							 ->whereIn('resource_task.due_at', $days)
		                     ->sum('resource_task.hours_estimate');
		    //Add them to the total hours of all projects
			$projects_total += $workload[$project->id]['hours_estimate'];

			//foreach resource
			foreach( $resources as $resource ) {
				$workload[$project->id]['resources'][$resource->id]['initials'] = $resource->initials;
				// get the resource's hours for this project
				$workload[$project->id]['resources'][$resource->id]['hours_estimate'] = DB::table('resource_task')
										->join('tasks', 'resource_task.task_id', '=', 'tasks.id')
										->where('resource_task.resource_id', $resource->id)
										->where('tasks.project_id', $project->id)
										->whereIn('resource_task.due_at', $days)
										->sum('resource_task.hours_estimate');
				//if the resource total is set, add this hour estimate to sum it up, else set it
				if( isset( $resources_total[$resource->id] ) ) {
					$resources_total[$resource->id]['hours_estimate'] += $workload[$project->id]['resources'][$resource->id]['hours_estimate'];
				} else {
					$resources_total[$resource->id]['hours_estimate'] = $workload[$project->id]['resources'][$resource->id]['hours_estimate'];	
				}
			}
		}
		if( $custom_date ) {
			$start_of_week = "Custom";
		} else {
			$start_of_week = $days[0];
		}

		return view('reports.workload', [
			'workload' => $workload,
			'resources' => $resources,
			'projects_total' => $projects_total,
			'resources_total' => $resources_total,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'start_of_week' => $start_of_week,
			]);
	}

	public function due_today()
	{
		$today= new DateTime('now');
		$today= $today->format('Y-m-d');
		//Get all the projects

		// get all tasks
		$tasks = DB::table('tasks')
		                     ->select(DB::raw('tasks.*, max(resource_task.due_at) as due_at, sum(resource_task.hours_estimate) as hours_estimate, (CASE WHEN min(resource_task.completed) <> 0 THEN "Yes" ELSE "No" END) as completed'))
		                     ->join('resource_task', 'resource_task.task_id', '=', 'tasks.id')
		                     ->groupBy('resource_task.task_id')
		                     ->where('resource_task.due_at', $today)
		                     ->get();
		// load the view and pass the tasks to it
		return view('reports.due_today', [
				'tasks' => $tasks
				]
			);
	}
}