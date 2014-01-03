<?php namespace Illuminate3\Vedette\Repositories\User;

interface UserRepository {

  public function all();

  public function find($id);

  public function create($input);

  public function update($input);

  public function delete($id);
/*
  public function feed();
*/
}