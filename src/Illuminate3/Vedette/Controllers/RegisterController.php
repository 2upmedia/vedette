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

		// Still getting Used to magniloquent
		// run passwords match check
		$check_password = Input::get( 'password' );
		$check_password_confirmation = Input::get( 'password_confirmation' );

		if ( !empty($check_password) ) {
			if ( $check_password != $check_password_confirmation ) {
			// Redirect to the new user page
				return Redirect::route('vedette.register')
					->withInput(Input::except('password', 'password_confirmation'))
					->with('error', trans('lingos::auth.error.passwords_not_match'));
			}
		}

//		$save_user_data = $this->user->create(Input::all());
		$save_user_data = Input::all();
		$save_user_data['confirmation_code'] = md5( uniqid(mt_rand(), true) );

		$save_user_data = $this->user->create($save_user_data);

		// Redirect to "home" with message
		if( $save_user_data->isSaved() ) {
		// Fire event to send confirmation_code to the User
			Event::fire('user.register', array(Auth::getUser()));
		// Then redirect
			return Redirect::route('vedette.home')
				->with('success', trans('lingos::auth.success.account'));
		}

		// OOPS! got an error
		return Redirect::route('vedette.register')
			->withInput(Input::except('password', 'password_confirmation'))
			->withErrors($save_user_data->errors());
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
    public function getConfirm( $code )
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