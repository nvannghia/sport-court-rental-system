<?php
namespace App\Repositories;

interface UserRepositoryInterface
{
    public function create(array $array);

    public function getUserById($id);

    public function getAllUser();
}
