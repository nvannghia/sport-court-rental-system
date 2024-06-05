<?php

namespace App\Repositories\Implements;

use App\Models\UserModel;
use App\Repositories\UserRepositoryInterface as UserRepositoryInterface;


class UserRepositoryImplement implements UserRepositoryInterface
{
    protected $user;

    public function create(array $arrayCheck, array $arrayInsert)
    {
        return UserModel::firstOrCreate($arrayCheck, $arrayInsert);
    }

    public function findByUsername($username)
    {
        return UserModel::where('username', $username)->first();
    }

    public function login($username, $password)
    {
        return UserModel::where('username', $username)->where('password', $password)->first();
    }

    public function getPasswordByUsername($username)
    {
        return UserModel::select('password')->where('username', $username)->first();
    }
}
