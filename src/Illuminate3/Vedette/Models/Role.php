<?php namespace Illuminate3\Vedette\Models;

//use Zizaco\Entrust\EntrustRole;
//use Robbo\Presenter\PresentableInterface;
use Eloquent;

//class Role extends EntrustRole implements PresentableInterface
//class Role extends Eloquent implements PresentableInterface
class Role extends Eloquent
{

	public function user()
	{
return $this->belongsTo('Illuminate3\Vedette\Models\User');
//	    return $this->hasOne('Account');
	}




    /**
     * Same presenter as the user model.
     * @return Robbo\Presenter\Presenter|UserPresenter
     */
    public function getPresenter()
    {
        return new UserPresenter($this);
    }

    /**
     * Provide an array of strings that map to valid roles.
     * @param array $roles
     * @return stdClass
     */
    public function validateRoles( array $roles )
    {
        $user = Confide::user();
        $roleValidation = new stdClass();
        foreach( $roles as $role )
        {
            // Make sure theres a valid user, then check role.
            $roleValidation->$role = ( empty($user) ? false : $user->hasRole($role) );
        }
        return $roleValidation;
    }
}