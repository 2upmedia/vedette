<?php namespace Illuminate3\Vedette\Controllers;

use Illuminate3\Vedette\Repositories\User\UserRepository as User;
use Config;
use View;
use Auth;
use Input;
use Redirect;
use Event;

/*
|--------------------------------------------------------------------------
| Manage User log in and out
|--------------------------------------------------------------------------
*/
class AuthController extends BaseController {

/*
|--------------------------------------------------------------------------
| Access $user through repository
|--------------------------------------------------------------------------
*/
	protected $user;

/*
|--------------------------------------------------------------------------
| Inject $user repoitory information into $this->user
|--------------------------------------------------------------------------
*/
	public function __construct(User $user)
	{
		$this->user = $user;
	}
/*
	public function __construct(ConfideRepository $confiderepo)
	{
		$this->confiderepo = $confiderepo;
	}
*/
/*
|--------------------------------------------------------------------------
| create log in for user
|--------------------------------------------------------------------------
*/
	public function index()
	{
		if (Auth::check())
		{
		// user is logged in. Bounce them back to "home" with friendly message
			return Redirect::route('vedette.home')
				->with('warning', trans('lingos::auth.logged_in'));
		}
		// User is not logged in so let's log them in
		return View::make(Config::get('vedette::vedette_views.login'));
	}

/*
|--------------------------------------------------------------------------
| Log in the the user
|--------------------------------------------------------------------------
*/
	public function store()
	{
	// use email as login credential
		if (Auth::attempt(array(
			'email' => Input::get('email'),
			'password' => Input::get('password'),
			'confirmed' => 1
			)))
		{
		// Fire event to update last_login in the Database
			Event::fire('user.login', array(Auth::getUser()));
		// login successful so send to "home" with message
			return Redirect::intended(Config::get('vedette::vedette_settings.home'))
				->with('success', trans('lingos::auth.success.login'));
		}
		// OOPS! Error'd redirect to login with error messages
		return Redirect::route('vedette.login')
			->withInput()
			->with('error',  trans('lingos::auth.error.authorize'));
	}

/*
|--------------------------------------------------------------------------
| Log out the user
|--------------------------------------------------------------------------
*/
	public function destroy()
	{
	// use laravel built in logout function
		Auth::logout();
	// Redirect to "home" with message
		return Redirect::route('vedette.home')
			->with('success', trans('lingos::auth.success.logout'));
	}

}
