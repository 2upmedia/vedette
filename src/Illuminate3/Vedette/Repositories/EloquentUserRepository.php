<?php namespace Illuminate3\Vedette\Repositories;

use Illuminate3\Vedette\Models\User as User;

class EloquentUserRepository implements UserRepositoryInterface {

  public function findAll()
  {
	return User::
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


/*
  public function create($input)
  {
    return User::create($input);
  }
*/



/*
  public function update($id)
  {
    $user = $this->find($id);

    $user->save(\Input::all());

    return $user;
  }
*/


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

		$user->user_id = $attributes['user_id'];

		return $user->save() ? $user : false;
	}


}
