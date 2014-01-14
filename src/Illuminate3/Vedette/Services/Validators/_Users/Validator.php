<?php namespace Illuminate3\Vedette\Services\Validators\Users;

use Illuminate3\Vedette\Services\Validators\ValidatorService;

class Validator extends ValidatorService {

     /**
     * User validation rules
     * @var array
     */

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

			'email' => 'unique:users|email',
			'password' => 'confirmed',
			'password_confirmation' => 'required|min:6'
		),
		"update" => array()
	);


    public static $rules = array(
/*
        'first_name' => 'required',
        'last_name'  => 'required',
*/
        'username' => 'required',
        'password'   => 'required|confirmed',
        'email'      => 'required|email'
    );

    /**
     * Perform validation
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Bool
     */
    public function passes()
    {
       if ( isset($this->data['id']) )
        {
            /**
             *  if password and conf_pass are empty
             *  The user don't want to change is password
             *  so remove password rules
             */
            if( empty($this->data['password']) AND empty($this->data['password_confirmation']) )
            {
                unset(static::$rules['password']);
                unset($this->data['password']);
            }
        }

        $status = parent::passes();
        unset($this->data['password_confirmation']);
        return $status;
    }

}
