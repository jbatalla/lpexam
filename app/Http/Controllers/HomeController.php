<?php namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{
		$newstr = str_shuffle('Test'); 
		return view('pages.one',compact('newstr'));
	}


}
