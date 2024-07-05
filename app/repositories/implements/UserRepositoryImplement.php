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

    public function findByEmail($email)
    {
        return UserModel::where('Email', $email)->first();
    }

    public function updateAvatar($userID, $url) // return null if failed(not found user, fail to update ...), otherwise return user updated
    {
        $user = UserModel::find($userID);

        if ($user) {
            $user->Avatar = $url;

            $isUpdated = $user->save();

            if ($isUpdated)
                return $user;

            return null;
        }

        return null;
    }
}
