<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use User;
use Auth;
use Validator;
use Input;
use Session;
use Redirect;
use Hash;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all resources
        $resources = DB::table('resources')
                             ->select(DB::raw('resources.id, resources.initials'))
                             ->get();
        //format array
        $profiles = array();
        $profiles[0] = "None";
        foreach( $resources as $resource ) {
            $profiles[$resource->id] = $resource->initials;
        }
        $user = User::find(Auth::user()->id);
        return view('users.index', [
                'resources' => $profiles,
                'user' => $user,
           ]);
    }
    public function update($id)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
            'email'      => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('profile')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $user = User::findOrFail($id);
            $user->name = Input::get('name');
            $user->email = Input::get('email');
            $user->resource_id = Input::get('resource_id');
            if( Input::get('password') != "" ) {
                $user->password = Hash::make(Input::get('password'));
            }
            $user->save();
            // redirect
            Session::flash('message', 'Successfully updated profile');
            return Redirect::to('profile');
        }
    }
}
