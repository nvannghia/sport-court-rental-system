<?php
namespace App\Repositories\Implements;

use App\Models\UserModel;
use App\Repositories\UserRepositoryInterface as UserRepositoryInterface;


class UserRepositoryImplement implements UserRepositoryInterface
{
    protected $user;

    public function create( array $array)
    {
        return UserModel::create($array);
    }

    public function getUserById($id)
    {
        return UserModel::find($id);
    }
    public function getAllUser()
    {
        return UserModel::all();
    }
}
