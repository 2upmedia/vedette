<?php namespace Illuminate3\Vedette\Repositories\User;

use Illuminate3\Vedette\Models\User as User;

class EloquentUserRepository implements UserRepository {

  public function all()
  {
    return User::all();
  }

  public function find($id)
  {
    return User::find($id);
  }

  public function create($input)
  {
    return User::create($input);
  }

  public function update($id)
  {
    $user = $this->find($id);

    $user->save(\Input::all());

    return $user;
  }

  public function delete($id)
  {
    $user = $this->find($id);

    return $user->delete();
  }



/**
 * Get the confirmation token
 *
 * @param string $token
 */
	public function confirmToken( $token )
	{
		return User::where('confirmation_code', '=', $token)->firstOrFail();
	}

	/**
	 * Find a user based on email
	 *
	 * @param  string $email
	 * @return User object
	 */
	public function getUserByMail( $email )
	{
		return User::where('email', '=', $email)->firstOrFail();
	}

	/**
	 * Find a user's confirmation code based on username
	 *
	 * @param  string $username
	 * @return User object
	 */
	public function getConfirmationCode( $username )
	{
		return User::where('username', $username)->pluck('confirmation_code');
	}


}