<?php
namespace App\Repositories;

interface UserRepositoryInterface
{
    public function create(array $arrayCheck, array $arrayInsert);

    public function findByEmail($username);

    public function updateAvatar($userID ,$url);

    public function changeProfileLink($userID, $typeLink, $valueLink);
}
