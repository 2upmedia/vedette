<?php namespace Illuminate3\Vedette\Repositories\User;

interface UserRepository {

  public function all();

  public function find($id);

  public function create($input);

  public function update($input);

  public function delete($id);


	/**
	 * Set the user confirmation to true.
	 *
	 * @param string $code
	 * @return bool
	 */
	public function confirmToken( $token );

	/**
	 * Find a user by the given email
	 *
	 * @param  string $email The email to be used in the query
	 * @return ConfideUser   User object
	 */
	public function getUserByMail( $email );


	/**
	 * Find a user by the given email
	 *
	 * @param  string $email The email to be used in the query
	 * @return ConfideUser   User object
	 */
	public function getConfirmationCode( $username );

}