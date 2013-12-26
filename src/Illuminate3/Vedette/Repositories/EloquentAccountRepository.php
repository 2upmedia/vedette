<?php namespace Illuminate3\Konto\Repositories\Account;

use Illuminate3\Konto\Models\Account as Account;
//use Illuminate3\Gengo\Models\Accountname as AccountName;

class EloquentAccountRepository implements AccountRepositoryInterface {

  public function findAll()
  {
	return Account::
//	with('accountname', 'accountaddress')
//	with('accountname')
//	with('accountaddress')
	with('accountname', 'accountaddress', 'accountemail', 'accountphone')
	->get();
//    return Account::all();
  }

  public function findById($id)
  {
    return Account::find($id);
  }


/*
  public function create($input)
  {
    return Account::create($input);
  }
*/



/*
  public function update($id)
  {
    $account = $this->find($id);

    $account->save(\Input::all());

    return $account;
  }
*/


  public function destroyById($id)
  {
/*
    $account = $this->find($id);
    return $account->delete();
*/
		$account = Account::find($id);
		$account->delete();
		return $account;
  }



	/**
	 * Save account in repository
	 *
	 * @param  array $attributes
	 * @param  mixed $account
	 * @return mixed boolean
	 */
	public function save(array $attributes, $account = null)
	{
		$account = $account ?: new Account;

		$account->user_id = $attributes['user_id'];

		return $account->save() ? $account : false;
	}


}
