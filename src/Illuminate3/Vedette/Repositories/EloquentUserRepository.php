<?php namespace Illuminate3\Vedette\Repositories;

use Illuminate3\Vedette\Models\User as User;

class EloquentUserRepository implements UserRepositoryInterface {

  public function findAll()
  {
//	return User::
//	with('username', 'useraddress')
//	with('username')
//	with('useraddress')
//	with('username', 'email')
//	->get();
    return User::all();
  }

  public function findById($id)
  {
    return User::find($id);
  }


  public function create($input)
  {
//    return User::create($input);
    return User::create($input);
  }


  public function update($id)
  {
    $user = $this->find($id);

    $user->save(\Input::all());

    return $user;
  }

  public function destroyById($id)
  {
/*
    $user = $this->find($id);
    return $user->delete();
*/
		$user = User::find($id);
		$user->delete();
		return $user;
  }



public function all()
{
return User::all();
}

public function find($id)
{
return User::find($id);
}

public function delete($id)
{
$user = $this->find($id);

return $user->delete();
}



	/**
	 * Save user in repository
	 *
	 * @param  array $attributes
	 * @param  mixed $user
	 * @return mixed boolean
	 */
	public function save(array $attributes, $user = null)
	{
		$user = $user ?: new User;
/* ----------------------------------------------------------------------------------------------------- */
echo "<pre>";
var_dump($user);
echo "</pre>";
exit();
/* ----------------------------------------------------------------------------------------------------- */
		$user->user_id = $attributes['user_id'];

		return $user->save() ? $user : false;
	}


}

/**
 * Ardent method overloading:
 * Before save the user. Generate a confirmation
 * code if is a new user.
 *
 * @param bool $forced
 * @return bool
 */
public function beforeSave($forced = false)
{
	if ( empty($this->id) )
	{
		$this->confirmation_code = md5( uniqid(mt_rand(), true) );
	}

	/*
	 * Remove password_confirmation field before save to
	 * database.
	 */
	if ( isset($this->password_confirmation) )
	{
		unset( $this->password_confirmation );
	}

	return true;
}

/**
 * Ardent method overloading:
 * After save, delivers the confirmation link email.
 * code if is a new user.
 *
 * @param $success
 * @param bool $forced
 * @return bool
 */
public function afterSave($success=true, $forced = false)
{
	if (! $this->confirmed && ! static::$app['cache']->get('confirmation_email_'.$this->id) )
	{
		// on behalf or the config file we should send and email or not
		if (static::$app['config']->get('confide::signup_email') == true)
		{
			$view = static::$app['config']->get('confide::email_account_confirmation');
			$this->sendEmail( 'confide::confide.email.account_confirmation.subject', $view, array('user' => $this) );
		}
		// Save in cache that the email has been sent.
		$signup_cache = (int)static::$app['config']->get('confide::signup_cache');
		if ($signup_cache !== 0)
		{
			static::$app['cache']->put('confirmation_email_'.$this->id, true, $signup_cache);
		}
	}

	return true;
}

/**
 * Overwrite the Ardent save method. Saves model into
 * database
 *
 * @param array $rules:array
 * @param array $customMessages
 * @param array $options
 * @param \Closure $beforeSave
 * @param \Closure $afterSave
 * @return bool
 */
public function saveC( array $rules = array(), array $customMessages = array(), array $options = array(), \Closure $beforeSave = null, \Closure $afterSave = null )
{
	$duplicated = false;

	if(! $this->id)
	{
		$duplicated = static::$app['confide.repository']->userExists( $this );
	}

	if(! $duplicated)
	{
		return $this->real_save( $rules, $customMessages, $options, $beforeSave, $afterSave );
	}
	else
	{
		static::$app['confide.repository']->validate();
		$this->validationErrors->add(
			'duplicated',
			static::$app['translator']->get('confide::confide.alerts.duplicated_credentials')
		);

		return false;
	}
}

/**
 * Runs the real eloquent save method or returns
 * true if it's under testing. Because Eloquent
 * and Ardent save methods are not Confide's
 * responsibility.
 *
 * @param array $rules
 * @param array $customMessages
 * @param array $options
 * @param \Closure $beforeSave
 * @param \Closure $afterSave
 * @return bool
 */
protected function real_save( array $rules = array(), array $customMessages = array(), array $options = array(), \Closure $beforeSave = null, \Closure $afterSave = null )
{
	if ( defined('CONFIDE_TEST') )
	{
		$this->beforeSave();
		$this->afterSave(true);
		return true;
	}
	else{

		/*
		 * This will make sure that a non modified password
		 * will not trigger validation error.
		 * @fixed Pull #110
		 */
		if( isset($rules['password']) && $this->password == $this->getOriginal('password') )
		{
			unset($rules['password']);
			unset($rules['password_confirmation']);
		}

		return parent::save( $rules, $customMessages, $options, $beforeSave, $afterSave );
	}
}
