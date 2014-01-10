<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//Event::subscribe('Illuminate3\Vedette\Services\Handlers\UserEventHandler');

/*
|--------------------------------------------------------------------------
| Route model binding
|--------------------------------------------------------------------------
*/
Route::model('user', 'User');
Route::model('role', 'Role');

/*
|--------------------------------------------------------------------------
| Route constraint patterns
|--------------------------------------------------------------------------
*/
Route::pattern('user', '[0-9]+');
Route::pattern('role', '[0-9]+');
Route::pattern('token', '[0-9a-z]+');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::get('api/users', array(
	'as'=>'api.users',
	'uses'=>'Illuminate3\Vedette\Controllers\AdminUsersController@getDatatable'
));


/*
|--------------------------------------------------------------------------
| General Routes
|--------------------------------------------------------------------------
*/
Route::get(Config::get('vedette::vedette_settings.home'), array(
	'as' => 'vedette.home',
	'uses' => 'Illuminate3\Vedette\Controllers\VedetteController@index')
);

/*
|--------------------------------------------------------------------------
| Password Routes
|--------------------------------------------------------------------------
|
| @ Package Config = password
|
*/
Route::group(array(
	'prefix' => Config::get('vedette::vedette_settings.prefix_pass')),
	function()
{
// Forgot Password
	Route::get('forgot', array(
		'as' => 'vedette.forgot',
		'uses' => 'Illuminate3\Vedette\Controllers\RemindersController@getRemind'
		));
	Route::post('forgot', array(
'before' => 'csrf',
		'as' => 'vedette.forgot',
		'uses' => 'Illuminate3\Vedette\Controllers\RemindersController@postRemind'
		));
// Reset password
	Route::get('reset/{token}', array(
		'as' => 'vedette.reset',
		'uses' => 'Illuminate3\Vedette\Controllers\RemindersController@getReset'
		));
	Route::post('reset/{token}', array(
		'as' => 'vedette.reset',
		'uses' => 'Illuminate3\Vedette\Controllers\RemindersController@postReset'
		));
});

/*
|--------------------------------------------------------------------------
| Athorization Routes
|--------------------------------------------------------------------------
|
| @ Package Config = auth
|
*/
Route::group(array(
	'prefix' => Config::get('vedette::vedette_settings.prefix_auth')),
	function()
{
// Login/Sign In
	Route::get('login', array(
		'as'   => 'vedette.login',
		'uses' => 'Illuminate3\Vedette\Controllers\AuthController@index'
	));
	Route::post('login', array(
'before' => 'csrf',
		'as'   => 'vedette.login',
		'uses' => 'Illuminate3\Vedette\Controllers\AuthController@store'
	));
// Logout/Sign Out
	Route::get('logout', array(
		'as'   => 'vedette.logout',
		'uses' => 'Illuminate3\Vedette\Controllers\AuthController@destroy'
	));
// Register/Sign Up
	Route::get('register', array(
		'as'   => 'vedette.register',
		'uses' => 'Illuminate3\Vedette\Controllers\RegisterController@index'
	));
	Route::post('register', array(
//'before' => 'csrf',
		'as'   => 'vedette.register',
		'uses' => 'Illuminate3\Vedette\Controllers\RegisterController@store'
	));
// Confirm User
	Route::get('confirm/{token}', array(
		'as' => 'vedette/confirm',
		'uses' => 'Illuminate3\Vedette\Controllers\RegisterController@getConfirm'
		));
	Route::post('confirm/{token}', array(
//'before' => 'csrf',
		'as' => 'vedette.confirm',
		'uses' => 'Illuminate3\Vedette\Controllers\RegisterController@postConfirm'
		));
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{

	# User Management
	Route::get('users/{user}/show', 'Illuminate3\Vedette\Controllers\AdminUsersController@getShow');
	Route::get('users/{user}/edit', 'Illuminate3\Vedette\Controllers\AdminUsersController@getEdit');
	Route::post('users/{user}/edit', 'Illuminate3\Vedette\Controllers\AdminUsersController@postEdit');
	Route::get('users/{user}/delete', 'Illuminate3\Vedette\Controllers\AdminUsersController@getDelete');
	Route::post('users/{user}/delete', 'Illuminate3\Vedette\Controllers\AdminUsersController@postDelete');
	Route::controller('users', 'Illuminate3\Vedette\Controllers\AdminUsersController');
	Route::get('users', array(
		'as'     => 'vedette.admin-users',
		'uses'   => 'Illuminate3\Vedette\Controllers\AdminUsersController@getIndex',
		'before' => 'auth.vedette:users.view'
	));


/*
	# User Role Management
	Route::get('roles/{role}/show', 'AdminRolesController@getShow');
	Route::get('roles/{role}/edit', 'AdminRolesController@getEdit');
	Route::post('roles/{role}/edit', 'AdminRolesController@postEdit');
	Route::get('roles/{role}/delete', 'AdminRolesController@getDelete');
	Route::post('roles/{role}/delete', 'AdminRolesController@postDelete');
	Route::controller('roles', 'AdminRolesController');
*/
	# Admin Dashboard
//	Route::controller('/', 'AdminDashboardController');
});




// User reset routes
//Route::get('auth/reset/{token}', 'Illuminate3\Vedette\Controllers\UsersController@getReset');
// User password reset
Route::post('auth/reset/{token}', 'Illuminate3\Vedette\Controllers\UsersController@postReset');
//:: User Account Routes ::
Route::post('auth/{user}/edit', 'Illuminate3\Vedette\Controllers\UsersController@postEdit');

//:: User Account Routes ::
//Route::post('auth/login', 'Illuminate3\Vedette\Controllers\UsersController@postLogin');
//Route::get('auth/login', 'Illuminate3\Vedette\UsersController@getLogin');

# User RESTful Routes (Login, Logout, Register, etc)
//Route::controller('user', 'Illuminate3\Vedette\Controllers\UsersController');

//:: Application Routes ::

# Filter for detect language
Route::when('contact-us','detectLang');

# Index Page - Last route, no matches
//Route::get('/', array('before' => 'detectLang','uses' => 'BlogController@getIndex'));







/*
|--------------------------------------------------------------------------
| Login/Logout/Register Routes
|--------------------------------------------------------------------------
*/
// Confide routes
//Route::get( 'user/create',                 'UserController@create');
//Route::post('user',                        'UserController@store');
//Route::get( 'user/login',                  'UserController@login');
//Route::post('user/login',                  'UserController@do_login');
Route::get( 'user/confirm/{code}',         'Illuminate3\Vedette\Controllers\VedetteController@confirm');
//Route::get( 'user/forgot_password',        'UserController@forgot_password');
//Route::post('user/forgot_password',        'UserController@do_forgot_password');
Route::get( 'user/reset_password/{token}', 'UserController@reset_password');
Route::post('user/reset_password',         'UserController@do_reset_password');
//Route::get( 'user/logout',                 'UserController@logout');
Route::get('/', array('before' => 'detectLang','uses' => 'BlogController@getIndex'));
Route::get('/', array('as' => 'home', 'before' => 'detectLang','uses' => 'BlogController@getIndex'));

Route::group(array(
	'prefix' => Config::get('vedette::vedette_settings.prefix_auth')),
	function()
{

// Shortcut Routes
	Route::get('admin', array(
		'as'     => 'vedette.admin',
		'uses'   => 'Illuminate3\Vedette\Controllers\VedetteController@index',
		'before' => 'auth.vedette:admin.view'
	));
	Route::get('users', array(
		'as'     => 'vedette.users',
		'uses'   => 'Illuminate3\Vedette\Controllers\UsersController@index',
		'before' => 'auth.vedette:users.view'
	));
	Route::get('groups', array(
		'as'     => 'vedette.groups',
		'uses'   => 'Illuminate3\Vedette\Controllers\GroupsController@index',
		'before' => 'auth.vedette:groups.view'
	));
	Route::get('permissions', array(
		'as'     => 'vedette.permissions',
		'uses'   => 'Illuminate3\Vedette\Controllers\PermissionsController@index',
		'before' => 'auth.vedette:groups.view'
	));


// Forgot Password Confirmation
//	Route::get('forgot-password/{passwordResetCode}', array(

});


/*
|--------------------------------------------------------------------------
| Resource Routes
|--------------------------------------------------------------------------
*/
/*
Route::group(array(
	'prefix' => Config::get('vedette::vedette_settings.prefix_auth'),
	'before' => 'auth.vedette'),
	function()
{
	Route::resource('users', 'Illuminate3\Vedette\Controllers\UsersController');
	Route::resource('groups', 'Illuminate3\Vedette\Controllers\GroupsController',array('except' => array('show')));
	Route::resource('permissions', 'Illuminate3\Vedette\Controllers\PermissionsController',array('except' => array('show')));
});
*/

/*
|--------------------------------------------------------------------------
| Users Permissions Routes
|--------------------------------------------------------------------------
*/
/*
Route::group(array(
	'prefix' => Config::get('vedette::vedette_settings.prefix_auth')),
	function()
{

// Users

	Route::get('users/{users}/permissions', array(
		'as'     => 'auth.users.permissions',
		'uses'   => 'Illuminate3\Vedette\Controllers\UsersPermissionsController@index',
		'before' => 'auth.vedette:users.update'
	));

	Route::put('users/{users}/permissions', array(
//		'as'     => 'auth.users.permissions',
		'uses'   => 'Illuminate3\Vedette\Controllers\UsersPermissionsController@update',
		'before' => 'auth.vedette:users.update'
	));

// Groups

	Route::get('groups/{groups}/permissions', array(
		'as'     => 'auth.groups.permissions',
		'uses'   => 'Illuminate3\Vedette\Controllers\GroupsPermissionsController@index',
		'before' => 'auth.vedette:groups.update'
	));

	Route::put('groups/{groups}/permissions', array(
		'uses'   => 'Illuminate3\Vedette\Controllers\GroupsPermissionsController@update',
		'before' => 'auth.vedette:groups.update'
	));


});
*/
/*
|--------------------------------------------------------------------------
| Admin auth filter
|--------------------------------------------------------------------------
| You need to give your routes a name before using this filter.
| I assume you are using resource. so the route for the UsersController index method
| will be auth.users.index then the filter will look for permission on users.view
| You can provide your own rule by passing a argument to the filter
|
*/
/*
Route::filter('auth.vedette', function($route, $request, $userRule = null)
{

	if ( !Sentry::check() )
	{
		Session::put('url.intended', URL::full());
		return Redirect::route('vedette.login');
	}

// no special route name passed, use the current name route
	if ( is_null($userRule) )
	{
		list($prefix, $module, $rule) = explode('.', Route::currentRouteName());
		switch ($rule)
		{
			case 'index':
			case 'show':
				$userRule = $module.'.view';
				break;
			case 'create':
			case 'store':
				$userRule = $module.'.create';
				break;
			case 'edit':
			case 'update':
				$userRule = $module.'.update';
				break;
			case 'destroy':
				$userRule = $module.'.delete';
				break;
			default:
				$userRule = Route::currentRouteName();
				break;
		}
	}

// no access to the request page and request page not the root admin page
	if ( !Sentry::hasAccess($userRule) and $userRule !== 'auth.view' )
	{
		return Redirect::route('vedette.login')->with('error', trans('lingos::sentry.permission_error.insufficient'));
	}
// no access to the request page and request page is the root admin page
	else if( !Sentry::hasAccess($userRule) and $userRule === 'auth.view' )
	{
//can't see the admin home page go back to home site page
		return Redirect::to('vedette.login')->with('error', trans('lingos::sentry.permission_error.insufficient'));
	}

});
*/