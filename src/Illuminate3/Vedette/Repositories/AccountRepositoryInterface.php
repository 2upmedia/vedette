<?php namespace Illuminate3\Konto\Repositories\Account;

/**
 * Account Repository Interface
 */
interface AccountRepositoryInterface {


  public function findAll();

  public function findById($id);

//  public function create($input);

//  public function update($input);

  public function destroyById($id);

	/**
	 * Save account
	 *
	 * @param  array  $attributes [description]
	 * @param  mixed $account null or Account
	 * @return mixed boolean false or Account
	 */
	public function save(array $attributes, $account = null);




}