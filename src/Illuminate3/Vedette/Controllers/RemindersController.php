<?php namespace Illuminate3\Vedette\Controllers;

use Config;
use View;
use Auth;
use Input;
use Lang;
use Redirect;
use Password;
use Hash;

/*
|--------------------------------------------------------------------------
| Manage password reminders and resets
|--------------------------------------------------------------------------
*/
class RemindersController extends BaseController {

/*
|--------------------------------------------------------------------------
| Display the password reminder view
|--------------------------------------------------------------------------
|
| @return Response
|
*/
	public function getRemind()
	{
		if (Auth::check())
		{
		// user is logged in. Bounce them back to "home" with friendly message
			return Redirect::back()
				->with('success', trans('lingos::auth.logged_in'));
		}
		// User is not logged in so let's send them to the reminder page
		return View::make(Config::get('vedette::vedette_views.forgot'));
	}

/*
|--------------------------------------------------------------------------
| Handle a POST request to remind a user of their password
|--------------------------------------------------------------------------
|
| @return Response
|
*/
	public function postRemind()
	{
		switch ($response = Password::remind(Input::only('email')))
		{
			case Password::INVALID_USER:
				return Redirect::back()
					->with('error', trans('lingos::auth.error.user'));
			case Password::REMINDER_SENT:
				return Redirect::route('vedette.home')
					->with('info', trans('lingos::auth.reminders.sent'));
		}
	}

/*
|--------------------------------------------------------------------------
| Display the password reset view for the given token
|--------------------------------------------------------------------------
|
| @param  string  $token
| @return Response
|
*/
	public function getReset($token = null)
	{
		if (is_null($token))
		{
			return Redirect::route('vedette.forgot')
				->with('error', trans('lingos::auth.error.token'));
		}
		return View::make(Config::get('vedette::vedette_views.reset'))
			->withInput(Input::except('password', 'password_confirmation'))
			->with('token', $token);
	}

/*
|--------------------------------------------------------------------------
| Handle a POST request to reset a user's password
|--------------------------------------------------------------------------
|
| @return Response
|
*/
	public function postReset()
	{
		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = Password::reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);
			$user->save();
		});

		switch ($response)
		{
			case Password::PASSWORD_RESET:
				return Redirect::route('vedette.login')
					->with('success', trans('lingos::auth.reminders.reset'));
			case Password::INVALID_TOKEN:
				return Redirect::route('vedette.forgot')
					->with('error', trans('lingos::auth.error.token'));
			case Password::INVALID_PASSWORD:
				return Redirect::back()
					->withInput(Input::except('password', 'password_confirmation'))
					->with('error', trans('lingos::auth.reminders.password'));
			case Password::INVALID_USER:
				return Redirect::back()
					->withInput(Input::except('password', 'password_confirmation'))
					->with('error', trans('lingos::auth.error.user'));
		}
	}

}