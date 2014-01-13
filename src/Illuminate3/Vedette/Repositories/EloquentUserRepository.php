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


	public function confirm($token)
	{
/* ----------------------------------------------------------------------------------------------------- */
echo "<pre>";
var_dump($token);
echo "</pre>";
exit();
/* ----------------------------------------------------------------------------------------------------- */
	}


/**
 * Set the user confirmation to true.
 *
 * @param string $code
 * @return bool
 */
	public function confirm($token)
	{
/* ----------------------------------------------------------------------------------------------------- */
echo "<pre>";
var_dump($token);
echo "</pre>";
exit();
/* ----------------------------------------------------------------------------------------------------- */
$user = User::where('confirmation_code', '=', $token)->firstOrFail();

//		$user = $this->model()->where('confirmation_code', '=', $token)->get()->first();
		if( $user ) {
			return $user->confirm();
		} else {
			return false;
		}
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
 * Get an activation code for the given user.
 *
 * @return string
 */
public function getActivationCode($user)
{
//	$this->activation_code = $activationCode = $this->getRandomString();

$activationCode = DB::table('users')->where('username', '$username')->pluck('confirmation_code');

	return $activationCode;
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
