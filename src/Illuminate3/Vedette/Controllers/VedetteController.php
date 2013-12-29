<?php namespace Illuminate3\Vedette\Controllers;

//use User;
use Illuminate3\Vedette\Models\User as User;
use Confide;
use View;
use Config;
use Input;
//use Sentry;
use Redirect;
use Lang;
use Event;
use Validator;
/*
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\UserExistsException;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\WrongPasswordException;
use Cartalyst\Sentry\Users\UserNotActivatedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Throttling\UserBannedException;
//use Cartalyst\Sentry\Users\UserInterface;
*/
use URL;
use Mail;
use Session;

class VedetteController extends BaseController {

	public function index_11()
	{
		return View::make(Config::get('vedette::vedette_views.auth'));
	}

	/**
	 * Account sign in.
	 *
	 * @return View
	 */
	public function getLogin_11()
	{
		// Is the user logged in?
		if (Sentry::check())
		{
			return Redirect::route('vedette.home');
//			$redirect = Session::get('loginRedirect', 'auth.home');

		}
		// Show the page
		return View::make(Config::get('vedette::vedette_views.login'));
	}

    /**
     * Authenticate the user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     *
     * @return Response
     */
    public function postLogin_11()
    {
        try
        {
            $remember = Input::get('remember_me', false);

            $userdata = array(
                'email' => Input::get('email'),
                'password' => Input::get('password')
            );

            $user = Sentry::authenticate($userdata, $remember);
            Event::fire('users.login', array($user));
            return Redirect::intended(Config::get('vedette::vedette_settings.home_route'))->with('success', trans('lingos::auth.success.login'));
        }
        catch (LoginRequiredException $e)
        {
//            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
            return Redirect::back()->withInput()->with('error',trans('lingos::auth.account.login_required'));
        }
        catch (PasswordRequiredException $e)
        {
//            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
            return Redirect::back()->withInput()->with('error',trans('lingos::auth.account.password_required'));
        }
        catch (WrongPasswordException $e)
        {
//            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
            return Redirect::back()->withInput()->with('error',trans('lingos::auth.account.wrong_password'));
        }
        catch (UserNotActivatedException $e)
        {
//            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
            return Redirect::back()->withInput()->with('error',trans('lingos::auth.account.not_activated'));
        }
        catch (UserNotFoundException $e)
        {
//            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
            return Redirect::back()->withInput()->with('error',trans('lingos::auth.account.not_found'));
        }
        catch (UserSuspendedException $e)
        {
//            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
            return Redirect::back()->withInput()->with('error',trans('lingos::auth.account.suspended'));
        }
        catch (UserBannedException $e)
        {
//            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
            return Redirect::back()->withInput()->with('error',trans('lingos::auth.account.banned'));
        }
    }



	/**
	 * Account sign up.
	 *
	 * @return View
	 */
	public function getRegister_11()
	{
		// Is the user logged in?
		if (Sentry::check())
		{
			return Redirect::route('account');
		}

		// Show the page
		return View::make(Config::get('vedette::vedette_views.register'));
	}

	/**
	 * Account sign up form processing.
	 *
	 * @return Redirect
	 */
	public function postRegister_11()
	{
		// Declare the rules for the form validation
		$rules = array(
			'first_name'       => 'required|min:3',
			'last_name'        => 'required|min:3',
			'email'            => 'required|email|unique:users',
			'email_confirm'    => 'required|email|same:email',
			'password'         => 'required|between:4,255',
			'confirm_password' => 'required|same:password',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		try
		{
			// Register the user
			$user = Sentry::register(array(
				'first_name' => Input::get('first_name'),
				'last_name'  => Input::get('last_name'),
				'email'      => Input::get('email'),
				'password'   => Input::get('password'),
			));

			// Data to be used on the email view
			$data = array(
				'user'          => $user,
				'activationUrl' => URL::route('activate', $user->getActivationCode()),
			);

			// Send the activation code through email
			Mail::send('emails.register-activate', $data, function($m) use ($user)
			{
				$m->to($user->email, $user->first_name . ' ' . $user->last_name);
				$m->subject('Welcome ' . $user->first_name);
			});

			// Redirect to the register page
			return Redirect::back()->with('success', trans('lingos::auth.success.signup'));
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
			$this->messageBag->add('email', trans('lingos::auth.account.already_exists'));
		}

		// Ooops.. something went wrong
		return Redirect::back()->withInput()->withErrors($this->messageBag);
	}

	/**
	 * User account activation page.
	 *
	 * @param  string  $actvationCode
	 * @return
	 */
	public function getActivate_11($activationCode = null)
	{
		// Is the user logged in?
		if (Sentry::check())
		{
			return Redirect::route('account');
		}

		try
		{
			// Get the user we are trying to activate
			$user = Sentry::getUserProvider()->findByActivationCode($activationCode);

			// Try to activate this user account
			if ($user->attemptActivation($activationCode))
			{
				// Redirect to the login page
				return Redirect::route('signin')->with('success', trans('lingos::auth.success.activate'));
			}

			// The activation failed.
			$error = trans('lingos::auth.error.activate');
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			$error = trans('lingos::auth.error.activate');
		}

		// Ooops.. something went wrong
		return Redirect::route('signin')->with('error', $error);
	}

	/**
	 * Forgot password page.
	 *
	 * @return View
	 */
	public function getForgotPassword_11()
	{
		// Show the page
//		return View::make('frontend.auth.forgot-password');
		return View::make(Config::get('vedette::vedette_views.forgot'));
	}

	/**
	 * Forgot password form processing page.
	 *
	 * @return Redirect
	 */
	public function postForgotPassword_11()
	{
		// Declare the rules for the validator
		$rules = array(
			'email' => 'required|email',
		);

		// Create a new validator instance from our dynamic rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::route('vedette.forgot-password')->withInput()->withErrors($validator);
		}

		try
		{
			// Get the user password recovery code
			$user = Sentry::getUserProvider()->findByLogin(Input::get('email'));

			// Data to be used on the email view
			$data = array(
				'user'              => $user,
				'forgotPasswordUrl' => URL::route('forgot-password-confirm', $user->getResetPasswordCode()),
			);
			// Send the activation code through email
//			Mail::send('emails.forgot-password', $data, function($m) use ($user)
			Mail::send(Config::get('vedette::vedette_views.forgot_password'), $data, function($m) use ($user)
			{
				$m->to($user->email, $user->first_name . ' ' . $user->last_name);
//				$m->subject('Account Password Recovery');
				$m->subject( trans('lingos::auth.account_password_recovery') );
			});
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			// Even though the email was not found, we will pretend
			// we have sent the password reset code through email,
			// this is a security measure against hackers.
		}

		//  Redirect to the forgot password
		return Redirect::route('vedette.forgot-password')->with('success', trans('lingos::auth.success.forgot-password'));
	}

	/**
	 * Forgot Password Confirmation page.
	 *
	 * @param  string  $passwordResetCode
	 * @return View
	 */
	public function getForgotPasswordConfirm_11($passwordResetCode = null)
	{
		try
		{
			// Find the user using the password reset code
			$user = Sentry::getUserProvider()->findByResetPasswordCode($passwordResetCode);
		}
		catch(Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			// Redirect to the forgot password page
			return Redirect::route('vedette.forgot-password')->with('error', trans('lingos::auth.account.not_found'));
		}

		// Show the page
//		return View::make('frontend.auth.forgot-password-confirm');
		return View::make(Config::get('vedette::vedette_views.forgot_confirm'));
	}

	/**
	 * Forgot Password Confirmation form processing page.
	 *
	 * @param  string  $passwordResetCode
	 * @return Redirect
	 */
	public function postForgotPasswordConfirm_11($passwordResetCode = null)
	{
		// Declare the rules for the form validation
		$rules = array(
			'password'         => 'required',
			'confirm_password' => 'required|same:password'
		);

		// Create a new validator instance from our dynamic rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::route('forgot-password-confirm', $passwordResetCode)->withInput()->withErrors($validator);
		}

		try
		{
			// Find the user using the password reset code
			$user = Sentry::getUserProvider()->findByResetPasswordCode($passwordResetCode);

			// Attempt to reset the user password
			if ($user->attemptResetPassword($passwordResetCode, Input::get('password')))
			{
				// Password successfully reseted
				return Redirect::route('signin')->with('success', trans('lingos::auth.success.reset_password'));
			}
			else
			{
				// Ooops.. something went wrong
				return Redirect::route('signin')->with('error', trans('lingos::auth.error.reset_password'));
			}
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			// Redirect to the forgot password page
			return Redirect::route('vedette.forgot-password')->with('error', trans('lingos::auth.account.not_found'));
		}
	}

	/**
	 * Logout page.
	 *
	 * @return Redirect
	 */
	public function getLogout_11()
	{
		// Log the user out
		Sentry::logout();

		// Redirect to the users page
		return Redirect::route('vedette.home')->with('success', trans('lingos::auth.success.logout'));
	}

    /**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * Inject the models.
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Users settings page
     *
     * @return View
     */
    public function getIndex()
    {
        list($user,$redirect) = $this->user->checkAuthAndRedirect('user');
        if($redirect){return $redirect;}

        // Show the page
        return View::make('site/user/index', compact('user'));
    }

    /**
     * Stores new user
     *
     */
    public function postIndex()
    {
        $this->user->username = Input::get( 'username' );
        $this->user->email = Input::get( 'email' );

        $password = Input::get( 'password' );
        $passwordConfirmation = Input::get( 'password_confirmation' );

        if(!empty($password)) {
            if($password === $passwordConfirmation) {
                $this->user->password = $password;
                // The password confirmation will be removed from model
                // before saving. This field will be used in Ardent's
                // auto validation.
                $this->user->password_confirmation = $passwordConfirmation;
            } else {
                // Redirect to the new user page
                return Redirect::to('user/create')
                    ->withInput(Input::except('password','password_confirmation'))
                    ->with('error', Lang::get('admin/users/messages.password_does_not_match'));
            }
        } else {
            unset($this->user->password);
            unset($this->user->password_confirmation);
        }

        // Save if valid. Password field will be hashed before save
        $this->user->save();

        if ( $this->user->id )
        {
            // Redirect with success message, You may replace "Lang::get(..." for your custom message.
            return Redirect::to('user/login1112')
                ->with( 'notice', Lang::get('user/user.user_account_created') );
        }
        else
        {
            // Get validation errors (see Ardent package)
            $error = $this->user->errors()->all();

            return Redirect::to('user/create')
                ->withInput(Input::except('password'))
                ->with( 'error', $error );
        }
    }

    /**
     * Edits a user
     *
     */
    public function postEdit($user)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), $user->getUpdateRules());


        if ($validator->passes())
        {
            $oldUser = clone $user;
            $user->username = Input::get( 'username' );
            $user->email = Input::get( 'email' );

            $password = Input::get( 'password' );
            $passwordConfirmation = Input::get( 'password_confirmation' );

            if(!empty($password)) {
                if($password === $passwordConfirmation) {
                    $user->password = $password;
                    // The password confirmation will be removed from model
                    // before saving. This field will be used in Ardent's
                    // auto validation.
                    $user->password_confirmation = $passwordConfirmation;
                } else {
                    // Redirect to the new user page
                    return Redirect::to('users')->with('error', Lang::get('admin/users/messages.password_does_not_match'));
                }
            } else {
                unset($user->password);
                unset($user->password_confirmation);
            }

            $user->prepareRules($oldUser, $user);

            // Save if valid. Password field will be hashed before save
            $user->amend();
        }

        // Get validation errors (see Ardent package)
        $error = $user->errors()->all();

        if(empty($error)) {
            return Redirect::to('user')
                ->with( 'success', Lang::get('user/user.user_account_updated') );
        } else {
            return Redirect::to('user')
                ->withInput(Input::except('password','password_confirmation'))
                ->with( 'error', $error );
        }
    }

    /**
     * Displays the form for user creation
     *
     */
    public function getCreate()
    {
        return View::make('site/user/create');
    }


	/**
	 * Displays the login form
	 *
	 */
	public function getLogin()
	{

//		if ( Auth::check() ) {
		if ( !empty($user->id) ) {
//			return Redirect::to('/');
			return Redirect::intended( Config::get('vedette::vedette_settings.home_route') );
		}
		return View::make( Config::get('vedette::vedette_views.login') );
	}

    /**
     * Attempt to do login
     *
     */
    public function postLogin()
    {
        $input = array(
            'email'    => Input::get( 'email' ), // May be the username too
            'username' => Input::get( 'email' ), // May be the username too
            'password' => Input::get( 'password' ),
            'remember' => Input::get( 'remember' ),
        );

        // If you wish to only allow login from confirmed users, call logAttempt
        // with the second parameter as true.
        // logAttempt will check if the 'email' perhaps is the username.
        // Check that the user is confirmed.
        if ( Confide::logAttempt( $input, true ) )
        {
            $r = Session::get('loginRedirect');
            if (!empty($r))
            {
                Session::forget('loginRedirect');
//                return Redirect::to($r);
return Redirect::intended($r)->with('success', trans('lingos::auth.success.login'));
            }
//            return Redirect::to('/');
return Redirect::intended(Config::get('vedette::vedette_settings.home_route'))->with('success', trans('lingos::auth.success.login'));
        }
        else
        {
            // Check if there was too many login attempts
            if ( Confide::isThrottled( $input ) ) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ( $this->user->checkUserExists( $input ) && ! $this->user->isConfirmed( $input ) ) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return Redirect::to('user/login11113')
                ->withInput(Input::except('password'))
                ->with( 'error', $err_msg );
        }
    }

    /**
     * Attempt to confirm account with code
     *
     * @param  string  $code
     */
    public function getConfirm( $code )
    {
        if ( Confide::confirm( $code ) )
        {
            return Redirect::to('vedette.login')
                ->with( 'notice', Lang::get('confide::confide.alerts.confirmation') );
        }
        else
        {
            return Redirect::to('vedette.home')
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_confirmation') );
        }
    }

    /**
     * Displays the forgot password form
     *
     */
    public function getForgot()
    {
        return View::make('site/user/forgot');
    }

    /**
     * Attempt to reset password with given email
     *
     */
    public function postForgot()
    {
        if( Confide::forgotPassword( Input::get( 'email' ) ) )
        {
            return Redirect::to('user/login11144')
                ->with( 'notice', Lang::get('confide::confide.alerts.password_forgot') );
        }
        else
        {
            return Redirect::to('user/forgot')
                ->withInput()
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_password_forgot') );
        }
    }

    /**
     * Shows the change password form with the given token
     *
     */
    public function getReset( $token )
    {

        return View::make('site/user/reset')
            ->with('token',$token);
    }


    /**
     * Attempt change password of the user
     *
     */
    public function postReset()
    {
        $input = array(
            'token'=>Input::get( 'token' ),
            'password'=>Input::get( 'password' ),
            'password_confirmation'=>Input::get( 'password_confirmation' ),
        );

        // By passing an array with the token, password and confirmation
        if( Confide::resetPassword( $input ) )
        {
            return Redirect::to('user/login1115')
            ->with( 'notice', Lang::get('confide::confide.alerts.password_reset') );
        }
        else
        {
            return Redirect::to('user/reset/'.$input['token'])
                ->withInput()
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_password_reset') );
        }
    }

    /**
     * Log the user out of the application.
     *
     */
    public function getLogout()
    {
        Confide::logout();
//        return Redirect::to('/');
return Redirect::route('vedette.home')->with('success', trans('lingos::auth.success.logout'));
    }

    /**
     * Get user's profile
     * @param $username
     * @return mixed
     */
    public function getProfile($username)
    {
        $userModel = new User;
        $user = $userModel->getUserByUsername($username);

        // Check if the user exists
        if (is_null($user))
        {
            return App::abort(404);
        }

        return View::make('site/user/profile', compact('user'));
    }

    public function getSettings()
    {
        list($user,$redirect) = User::checkAuthAndRedirect('user/settings');
        if($redirect){return $redirect;}

        return View::make('site/user/profile', compact('user'));
    }

    /**
     * Process a dumb redirect.
     * @param $url1
     * @param $url2
     * @param $url3
     * @return string
     */
    public function processRedirect($url1,$url2,$url3)
    {
        $redirect = '';
        if( ! empty( $url1 ) )
        {
            $redirect = $url1;
            $redirect .= (empty($url2)? '' : '/' . $url2);
            $redirect .= (empty($url3)? '' : '/' . $url3);
        }
        return $redirect;
    }

}
