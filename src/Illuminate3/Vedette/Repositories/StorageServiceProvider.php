<?php namespace Illuminate3\Vedette\Repositories;

use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider {

  public function register()
  {
    $this->app->bind(
      'Illuminate3\Vedette\Repositories\User\UserRepository',
      'Illuminate3\Vedette\Repositories\User\EloquentUserRepository'
    );
/*
    $this->app->bind(
      'Cribbb\Storage\Post\PostRepository',
      'Cribbb\Storage\Post\EloquentPostRepository'
    );
*/

  }

}