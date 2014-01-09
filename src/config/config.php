<?php

return array(

/*
|--------------------------------------------------------------------------
| Package Settings
|--------------------------------------------------------------------------
|
| Use package Notifications
|
*/
'package_notifications' => true,

'available_language' => array('en', 'pt', 'es'),

/*
|--------------------------------------------------------------------------
| General configs used for naming conventions
|--------------------------------------------------------------------------
*/
'vedette_config' => array(
	'site_name'				=> 'Vedette',
	'title'					=> 'My Admin Panel',
	'site_team'				=> 'Vedette Team',
	'description'			=> 'Laravel 4 Admin Panel'
),


/*
|--------------------------------------------------------------------------
| Package settings
|--------------------------------------------------------------------------
*/
'vedette_settings' => array(
	'prefix_auth'			=> 'auth',
	'prefix_pass'			=> 'password',
//	'prefix_register'		=> 'register',
	'home'					=> '/',
),


/*
|--------------------------------------------------------------------------
| General views and standard package views
|--------------------------------------------------------------------------
*/
'vedette_views' => array(

	// The layoiut to use : change to what matches your application
//	'layout'				=> 'vedette::layouts',
'layout' => 'frontend/layouts/default',

	// Dashboard area : change to something more appropriate or build out what is provided
	'dashboard'				=> 'vedette::auth.index',
	'datatable'				=> 'vedette::datatable',
	'datalist'				=> 'vedette::list',

	// Auth views
	'auth'					=> 'vedette::auth.index',
	'login'					=> 'vedette::auth.login',
	'register'				=> 'vedette::auth.register',
	'forgot'				=> 'vedette::auth.forgot',
	'reset'					=> 'vedette::auth.reset',

	// Users views
	'users_index'			=> 'vedette::users.index',
	'users_show'			=> 'vedette::users.show',
	'users_edit'			=> 'vedette::users.edit',
	'users_create'			=> 'vedette::users.create',
	'users_permission'		=> 'vedette::users.permission',

	//Groups Views
	'groups_index'			=> 'vedette::groups.index',
	'groups_create'			=> 'vedette::groups.create',
	'groups_edit'			=> 'vedette::groups.edit',
	'groups_permission'		=> 'vedette::groups.permission',

	//Permissions Views
	'permissions_index'		=> 'vedette::permissions.index',
	'permissions_edit'		=> 'vedette::permissions.edit',
	'permissions_create'	=> 'vedette::permissions.create',

	//Throttling Views
	'throttle_status'		=> 'vedette::throttle.index',

	//Email Views
	'forgot_password'		=> 'vedette::emails.forgot-password',
	'register_activate'		=> 'vedette::emails.register-activate',
	'reminder'				=> 'vedette::emails.reminder',
	'email_layout'			=> 'vedette::emails.layouts.default',

),


    /*
    |--------------------------------------------------------------------------
    | Login Throttle
    |--------------------------------------------------------------------------
    |
    | Defines how many login failed tries may be done within
    | the 'throttle_time_period', which is in minutes.
    |
    */

    'throttle_limit' => 9,
    'throttle_time_period' => 2,

    /*
    |--------------------------------------------------------------------------
    | Login Throttle Field
    |--------------------------------------------------------------------------
    |
    | Login throttle is done using the remote ip address
    | and a provided credential. Email and username are likely values.
    |
    | Default: email
    |
    */
    'login_cache_field' => 'email',


    /*
    |--------------------------------------------------------------------------
    | Email Views
    |--------------------------------------------------------------------------
    |
    | The VIEWS used to email messages for some Confide events:
    |
    | By default, the out of the box confide views are used
    | but you can create your own forms and replace the view
    | names here. For example
    |
    |  // To use app/views/email/confirmation.blade.php:
    |
    | 'email_account_confirmation' => 'email.confirmation'
    |
    |
    */

    'email_reset_password' =>       'confide::emails.passwordreset', // with $user and $token.
    'email_account_confirmation' => 'confide::emails.confirm', // with $user


    /*
    |--------------------------------------------------------------------------
    | Signup (create) Cache
    |--------------------------------------------------------------------------
    |
    | By default you will only can only register once every 2 hours
    | (120 minutes) because you are not able to receive a registration
    | email more often then that.
    |
    | You can adjust that limitation here, set to 0 for no caching.
    | Time is in minutes.
    |
    |
    */
    'signup_cache' => 120,



    /*
    |--------------------------------------------------------------------------
    | Signup E-mail and confirmation (true or false)
    |--------------------------------------------------------------------------
    |
    | By default a signup e-mail will be send by the system, however if you
    | do not want this to happen, change the line below in false and handle
    | the confirmation using another technique, for example by using the IPN
    | from a payment-processor. Very usefull for websites offering products.
    |
    | signup_email:
    | is for the transport of the email, true or false
    | If you want to use an IPN to trigger the email, then set it to false
    |
    | signup_confirm:
    | is to decide of a member needs to be confirmed before he is able to login
    | so when you set this to true, then a member has to be confirmed before
    | he is able to login, so if you want to use an IPN for confirmation, be
    | sure that the ipn process also changes the confirmed flag in the member
    | table, otherwise they will not be able to login after the payment.
    |
    */
    'signup_email'      => true,
    'signup_confirm'    => true,


/*
|--------------------------------------------------------------------------
| Validation rules location
|--------------------------------------------------------------------------
| Need to add a section here to allow overriding of the rules used in the package
|--------------------------------------------------------------------------
*/

'validation' => array(
	'user'					=> 'Illuminate3\Vedette\Services\Validators\Users\Validator',
	'permission'			=> 'Illuminate3\Vedette\Services\Validators\Permissions\Validator',
),

);
