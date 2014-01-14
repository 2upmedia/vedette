<?php namespace Illuminate3\Vedette\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Config;
use DB;
use Hash;
use Datetime;

class UserSeedCommand extends Command {

    /**
    * The console command name.
    *
    * @var string
    */
    protected $name = 'vedette:user';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Create a new user with superuser role';

    /**
     * Exceute the console command
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return void
     */

    public function fire()
    {
/*
        $this->line('Welcome to the user generator.');

//        $userdata['first_name']  = $this->ask('What is your First Name?');
//        $userdata['last_name']   = $this->ask('What is your Last Name?');
        $userdata['username']   = $this->ask('What is your User Name?');
        $userdata['email']       = $this->ask('What is your email?');
        $userdata['password']    = $this->secret('Enter a password?');
//        $userdata['permissions'] = array('superuser' => 1);
        $userdata['confirmed'] = 1;
        $userdata['permissions'] = array('confirmed' => 1);

        $userdata['confirmation_code'] = md5( microtime().Config::get('app.key') );

//		$userdata->save();
//        $user = Sentry::register($userdata, true);
*/

$userdata = [
	[
	'username' => $this->ask('What is your User Name?'),
	'email' => $this->ask('What is your email?'),
	'password' => Hash::make($this->secret('Enter a password?')),
	'confirmation_code' => md5( microtime().Config::get('app.key') ),
	'confirmed' => 1,
	'created_at' => new DateTime,
	'updated_at' => new DateTime,
	]
];

DB::table('users')->insert($userdata);
//$this->info('<info>User ' . $userdata['username'] . ' added.</info>');
$this->info('<info>User added.</info>');

/*
        $users = array(
            array(
                'username'      => 'admin',
                'email'      => 'admin@example.org',
                'password'   => Hash::make('admin'),
                'confirmed'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'username'      => 'user',
                'email'      => 'user@example.org',
                'password'   => Hash::make('user'),
                'confirmed'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            )
        );

        DB::table('users')->insert( $users );
*/


//$this->call('VedetteDatabaseSeeder');
//$this->call('db:seed', array('--class' => 'VedetteDatabaseSeeder'));


//$this->info('<info>User ' . $users['username'] . ' added.</info>');

    }

}
