<?php namespace Illuminate3\Konto\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;
use Carbon;

class AccountPresenter extends BasePresenter
{

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
     * Returns the date of the user creation,
     * on a good and more readable format :)
     *
     * @return string
     */
    public function created_at1()
    {
        return String::date($this->created_at);
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


public function created_at()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->resource->created_at, 'Europe/Berlin')
                     ->toFormattedDateString();
    }


}