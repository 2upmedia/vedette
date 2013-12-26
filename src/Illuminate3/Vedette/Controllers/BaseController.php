<?php namespace Illuminate3\Vedette\Controllers;

use Controller;
use View;
use Config;

class BaseController extends Controller {

	/**
	 * Initializer.
	 *
	 * @access   public
	 * @return \BaseController
	 */
	public function __construct()
	{
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
		//share the config option to all the views
		View::share('vedette', Config::get('vedette::vedette_config'));
	}

    /**
     * get the validation service
     *
     * @param  string $service
     * @param  array $inputs
     * @return Object
     */
/*
    protected function getValidationService($service, array $inputs = array())
    {
        $class = '\\'.ltrim(Config::get("vedette::validation.{$service}"), '\\');
        return new $class($inputs);
    }
*/
}