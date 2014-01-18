<?php namespace Illuminate3\Vedette\Models;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Eloquent;
use DB;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'users';

	/**
	* Properties that can be mass assigned
	*
	* @var array
	*/
	protected $fillable = array('username', 'first_name', 'last_name', 'email', 'password', 'confirmation_code', 'created_at');

	public $presenter = 'Illuminate3\Vedette\Services\Presenters\UserPresenter';

	/**
	* The attributes excluded from the model's JSON form.
	*
	* @var array
	*/
	protected $hidden = array('password');


	/**
	 * Indicates if the model should soft delete.
	 *
	 * @var bool
	 */
	protected $softDelete = false;


	/**
	* Validation rules
	*/
	public static $rules1 = array(
		"save" => array(
			'username' => 'required',
			'email' => 'required|email',
			'password' => 'required|min:6'
		),
		"create" => array(
			'username' => 'unique:users',
			'email' => 'unique:users',
/*
			'email' => 'unique:users|email',
			'password' => 'confirmed',
			'password_confirmation' => 'required|min:6'
*/
		),
		"update" => array()
	);


  /**
   * Factory
   */
/*
  public static $factory = array(
    'username' => 'string',
    'email' => 'email',
    'password' => 'string',
  );
*/
  /**
   * Auto purge redundant attributes
   *
   * @var bool
   */
//  public $autoPurgeRedundantAttributes = true;

  /**
   * Get the unique identifier for the user.
   *
   * @return mixed
   */
  public function getAuthIdentifier()
  {
    return $this->getKey();
  }

  /**
   * Get the password for the user.
   *
   * @return string
   */
  public function getAuthPassword()
  {
    return $this->password;
  }

  /**
   * Get the e-mail address where password reminders are sent.
   *
   * @return string
   */
  public function getReminderEmail()
  {
    return $this->email;
  }
/**
 * Retrieve data from Account_names table
 *
 * @var string
 */
public function passwordPhrase()
{
	return $this->hasOne('Illuminate3\Vedette\Models\PasswordPhrase');
}

public function userGovernor()
{
	return $this->hasOne('Illuminate3\Vedette\Models\UserGovernor');
}


public function roles() {
	return $this->belongsToMany('Illuminate3\Vedette\Models\Role');
//	return $this->belongsToMany('Illuminate3\Vedette\Models\Role', 'role_user');
//	return $this->belongsToMany('Illuminate3\Vedette\Models\Role', 'role_user')->withPivot('name');;
}

public function permissions() {
	return $this->hasMany('Illuminate3\Vedette\Models\Permission');
}

public function hasRole($key) {
	foreach($this->roles as $role){
		if($role->name === $key)
		{
			return true;
		}
	}
	return false;
}


} // end of model/User
