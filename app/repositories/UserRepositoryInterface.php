<?php
namespace App\Repositories;

interface UserRepositoryInterface
{
    public function create(array $arrayCheck, array $arrayInsert);

    public function findByUsername($username);

    public function login($username, $password);

    public function getPasswordByUsername($username);
}