<?php namespace Illuminate3\Vedette\Services\Subscribers;

//use Config;
use Carbon;
use Auth;
//use Eloquent;
//use Illuminate3\Vedette\Models\User;
//use User;
use Event;

/*
|--------------------------------------------------------------------------
| Event Listners for user management
|--------------------------------------------------------------------------
*/

class UserSubscriber
{

/*
	protected $table = 'users';
	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}
*/

/*
|--------------------------------------------------------------------------
| Event Listners for user management
|--------------------------------------------------------------------------
|
| @param  Illuminate\Events\Dispatcher  $events
| @return array
|
*/

	public function subscribe($events)
	{
		$events->listen('user.fire', 'Illuminate3\Vedette\Services\Subscribers\UserSubscriber@onFire', 5);
		$events->listen('user.login', 'Illuminate3\Vedette\Services\Subscribers\UserSubscriber@onLogin', 5);
		$events->listen('user.register', 'Illuminate3\Vedette\Services\Subscribers\UserSubscriber@onRegister', 5);
		$events->listen('user.reset', 'Illuminate3\Vedette\Services\Subscribers\UserSubscriber@onReset', 5);
	}

	public function onFire()
	{
		dd('user signed up');
	}

	public function onLogin($user)
	{
//		$user = User::findOrFail(Auth::user()->user_id);
		$user->last_login = Carbon::now()->toDateTimeString();
		$user->save();
//		Event::fire('user.fire');
	}


}
