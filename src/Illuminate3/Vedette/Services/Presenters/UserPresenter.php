<?php namespace Illuminate3\Vedette\Services\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;
use Illuminate3\Vedette\Models\User as User;

class UserPresenter extends BasePresenter
{

protected $user;

	public function __construct(User $user)
	{
		$this->presenter = $user;
	}

	public function created_at()
	{
		return date('m-d-y', strtotime($this->presenter->created_at));
	}



    public function isActivated()
    {
        if( $this->confirmed )
        {
            return false;
        }
        else
        {
            return true;
        }

    }

    public function currentUser()
    {
        if( Auth::check() )
        {
            return Auth::user()->email;
        }
        else
        {
            return null;
        }
    }

    public function displayDate()
    {
        return date('m-d-y', strtotime($this->created_at));
    }

    /**
     * Returns the date of the user last update,
     * on a good and more readable format :)
     *
     * @return string
     */
    public function updated_at()
    {
        return String::date($this->updated_at);
    }
}