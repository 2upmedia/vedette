<?php namespace Illuminate3\Konto\Observers;

/**
 * Laravel
 */
use Validator;
use Session;
use trans;

/**
 * Account Observer
 */
class AccountObserver {

	/**
	 * Validate the model before creating
	 *
	 * @param  [type] $account [description]
	 * @return [type]             [description]
	 */
	public function creating($account)
	{
		$validation = Validator::make($account->toArray(), $account->rules['create']);

		if($validation->passes()) {
			return true;
		}

		Session::flash('errors', $validation->messages());

		return false;
	}

	/**
	 * Validate the model before updating
	 *
	 * @param  [type] $account [description]
	 * @return [type]             [description]
	 */
	public function updating($account)
	{
		$account->rules['edit']['user_id'][1] = str_replace('{id}', $account->id, $account->rules['edit']['user_id'][1]);

		$validation = Validator::make($account->toArray(), $account->rules['edit']);

		if($validation->passes()) {
			return true;
		}

		Session::flash('errors', $validation->messages());

		return false;
	}

}