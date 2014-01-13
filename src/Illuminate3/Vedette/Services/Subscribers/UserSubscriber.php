<?php namespace Illuminate3\Vedette\Services\Subscribers;

//use Config;
use Carbon;
use Auth;
use Config;
//use Illuminate3\Vedette\Models\User;
use Mail;
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
		$events->listen('user.confirm', 'Illuminate3\Vedette\Services\Subscribers\UserSubscriber@onConfirm', 5);
	}

	public function onFire()
	{
//		$user = User::findOrFail(Auth::user()->user_id);
		dd('user signed up');
//		Event::fire('user.fire');
	}

	public function onLogin($user)
	{
//		Event::fire('user.fire');
		$user->last_login = Carbon::now()->toDateTimeString();
		$user->save();
	}

	public function onConfirm($user)
	{
//		Event::fire('user.fire');
		$user->confirmed = 1;
		$user->save();
	}

	public function onReset($user)
	{
		dd('user signed up');
	}


	public function onRegister($user)
	{
		dd('user signed up');
	}


}
