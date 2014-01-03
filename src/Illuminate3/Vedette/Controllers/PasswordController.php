<?php namespace Illuminate3\Vedette\Controllers;

use Config;
use View;
use Auth;
use Input;
use Redirect;
use Password;

class PasswordController extends BaseController {

  public function remind()
  {
//    return View::make('password.remind');
		return View::make(Config::get('vedette::vedette_views.forgot'));
  }

  public function request()
  {
    $credentials = array('email' => Input::get('email'));

    return Password::remind($credentials);
  }

  public function reset($token)
  {
    return View::make('password.reset')->with('token', $token);
  }

  public function update()
  {
    $credentials = array('email' => Input::get('email'));

    return Password::reset($credentials, function($user, $password)
    {
      $user->password = Hash::make($password);

      $user->save();

      return Redirect::to('login')->with('flash', 'Your password has been reset');
    });
  }

}