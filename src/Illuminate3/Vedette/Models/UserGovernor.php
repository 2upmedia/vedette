<?php namespace Illuminate3\Vedette\Models;

use Eloquent;

class UserGovernor extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_governors';

	/**
	 * Fillabel attributes of the model
	 *
	 * @var array
	 */
	protected $fillable = ['user_id'];

	/**
	 * Guarded attributes of the model
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	/**
	 * Enable Soft deletion on the model
	 *
	 * @var string
	 */
	protected $softDelete = true;

/*
	public function accounts()
	{
	    return $this->hasMany('Accounts');
	}


	public function environs_name_suffix_type()
	{
	    return $this->hasOne('Environs_name_suffix_type');
	}

	public function environs_name_prefix_type()
	{
	    return $this->hasOne('Environs_name_prefix_type');
	}

	public function environs_usage_type()
	{
	    return $this->hasOne('Environs_usage_type');
	}
*/
	public function user()
	{
return $this->belongsTo('Illuminate3\Vedette\Models\User');
//	    return $this->hasOne('Account');
	}
/*
	public function user()
	{
	    return $this->hasOne('User');
	}
*/
}