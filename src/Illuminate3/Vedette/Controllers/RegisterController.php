<?php namespace Illuminate3\Vedette\Controllers;

//use Illuminate3\Vedette\Repositories\User\UserRepository as User;
use Illuminate3\Vedette\Repositories\User\UserRepository;
use Config;
use View;
use Auth;
use Input;
use Redirect;
use Event;
use Mail;
use Hash;
//use Illuminate3\Vedette\Controllers\Register as Register;

/*
|--------------------------------------------------------------------------
| Manage User Registration
|--------------------------------------------------------------------------
*/
class RegisterController extends BaseController {

/*
|--------------------------------------------------------------------------
| User Repository
|--------------------------------------------------------------------------
*/
	protected $user;

/*
	public function __construct(User $user)
	{
		$this->user = $user;
	}
*/
	public function __construct(UserRepository $repository)
	{
		$this->repository = $repository;
	}

/*
|--------------------------------------------------------------------------
| Create Signup/Register Page
|--------------------------------------------------------------------------
*/
	public function index()
	{
		if ( Auth::check() ) {
		// user is logged in. Bounce them back to "home" with friendly message
			return Redirect::route('vedette.home')
				->with('warning', trans('lingos::auth.logged_in'));
		}
		return View::make( Config::get('vedette::vedette_views.register') );
	}

	public function store()
	{
		$validation = $this->getValidationService('user');

		if ( $validation->passes() ) {
		// run passwords match check
			$check_password = Input::get('password');
			$check_password_confirmation = Input::get('password_confirmation');

			if ( !empty($check_password) ) {
				if ( $check_password != $check_password_confirmation ) {
				// Redirect to the new user page
					return Redirect::route('vedette.register')
						->withInput(Input::except('password', 'password_confirmation'))
						->with('error', trans('lingos::auth.error.passwords_not_match'));
				}
			}

			$user = Input::except('password', 'password_confirmation');
			$user['password'] = Hash::make('secret');
			$user['confirmation_code'] = md5( uniqid(mt_rand(), true) );
			$user = $this->repository->create($user);

		// Redirect to "home" with message
			if( $user->save() ) {
			// get the confirmation_code for the User
				$confirmation_code =  $this->repository->getConfirmationCode( Input::get('username') );

			// Data to be used on the email view
				$data = array(
					'username'          => Input::get('username'),
					'confirmation_code' => $confirmation_code,
					'confirmationUrl' => route('vedette.confirm', $confirmation_code),
				);

				$view = Config::get('vedette::vedette_emails.email_register');

			// Send the activation code through email
				Mail::send($view, $data, function($mail_data) use ($user)
				{
					$mail_data->to( $user->email, $user->username );
					$mail_data->subject( trans('lingos::auth.registration') . ' ' . $user->username );
				});

			// Then redirect
				return Redirect::route('vedette.home')
					->with('success', trans('lingos::auth.success.account'));
			}
		}
		// OOPS! got an error
		return Redirect::route('vedette.register')
			->withInput(Input::except('password', 'password_confirmation'))
			->withErrors($save_user_data->errors());
	}

/*
|--------------------------------------------------------------------------
| Display the confirmation view for the given token
|--------------------------------------------------------------------------
|
| @param  string  $token
| @return Response
|
*/
	public function getConfirm($token = null)
	{
		if ( Auth::check() ) {
		// user is logged in. Bounce them back to "home" with friendly message
			return Redirect::route('vedette.home')
				->with('warning', trans('lingos::auth.logged_in'));
		}
		if (is_null($token))
		{
			return Redirect::route('vedette.confirm')
				->with('error', trans('lingos::auth.error.token'));
		}
		return View::make(Config::get('vedette::vedette_views.confirm'))
			->withInput(Input::except('password', 'password_confirmation'))
			->with('token', $token);
	}

/*
|--------------------------------------------------------------------------
| Handle the Post response for confirmation
|--------------------------------------------------------------------------
|
| @param  string  $token
|
*/
	public function postConfirm($token)
	{
		if ( Auth::check() ) {
		// user is logged in. Bounce them back to "home" with friendly message
			return Redirect::route('vedette.home')
				->with('warning', trans('lingos::auth.logged_in'));
		}
		if ( $this->repository->confirmToken($token) ) {
		// use email to grab user info
			$user = $this->repository->getUserByMail( Input::get('email') );
		// Fire event to confirm user in the Database
			Event::fire( 'user.confirm', $user );
		// login successful so send to "home" with message
			return Redirect::intended(Config::get('vedette::vedette_settings.home'))
				->with('success', trans('lingos::auth.success.register'));
		} else {
		// OOPS! Error'd redirect to login with error messages
			return Redirect::route('vedette.login')
				->withInput(Input::except('password', 'password_confirmation'))
				->with('error',  trans('lingos::auth.error.wrong_confirmation'));
		}
	}

}