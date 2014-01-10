<?php namespace Illuminate3\Vedette\Controllers;

use Illuminate3\Vedette\Repositories\User\UserRepository as User;
use Config;
use View;
use Auth;
use Input;
use Redirect;
use Event;
use Mail;
use Hash;

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

	public static $app;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

/*
|--------------------------------------------------------------------------
| Create Signup/Register Page
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
		return View::make(Config::get('vedette::vedette_views.register'));
	}

	public function store()
	{

$validation = $this->getValidationService('user');

if( $validation->passes() ) {

		// Still getting Used to magniloquent
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

//		$save_user_data = $this->user->create(Input::all());
		$user = Input::except('password', 'password_confirmation');
		$user['password'] = Hash::make('secret');
		$user['confirmation_code'] = md5( uniqid(mt_rand(), true) );

		$user = $this->user->create($user);

		// Redirect to "home" with message
		if( $user->save() ) {
		// Fire event to send confirmation_code to the User
//			Event::fire('user.register', array('email'=>Input::get('email')) );

// Data to be used on the email view
$data = array(
	'username'          => Input::get('username'),
	'confirmation_code' => $user->getActivationCode(Input::get('username')),
	'confirmationUrl' => route('vedette.confirm', $user->getActivationCode(Input::get('username'))),
);


$view = Config::get('vedette::vedette_emails.email_register');
/*
Mail::send(
	$view,
	array(
		'email' => Input::get('email'),
		'username' => Input::get('username')
		),
	function($message) use ($user)
	{
    $message->to(Input::get('email'), Input::get('username'))->subject( trans('lingos::auth.registration') );
});
*/


// Send the activation code through email
Mail::send($view, $data, function($m) use ($user)
{
	$m->to($user->email, $user->username);
	$m->subject(trans('lingos::auth.registration') . ' ' . $user->username);
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
| Display the password reset view for the given token
|--------------------------------------------------------------------------
|
| @param  string  $token
| @return Response
|
*/
	public function getConfirm($token = null)
	{
		if (is_null($token))
		{
			return Redirect::route('vedette.confirm')
				->with('error', trans('lingos::auth.reminders.token'));
		}
		return View::make(Config::get('vedette::vedette_views.confirm'))
			->withInput(Input::except('password', 'password_confirmation'))
			->with('token', $token);
	}



/*
|--------------------------------------------------------------------------
| Create Signup/Register Page
|--------------------------------------------------------------------------
*/
    /**
     * Attempt to confirm account with code
     *
     * @param  string  $code
     */
    public function postConfirm( $code )
    {
        if ( Confide::confirm( $code ) )
        {
            return Redirect::to('user/login')
                ->with( 'notice', Lang::get('confide::confide.alerts.confirmation') );
        }
        else
        {
            return Redirect::to('user/login')
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_confirmation') );
        }
    }

}