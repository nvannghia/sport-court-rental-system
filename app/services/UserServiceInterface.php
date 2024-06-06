<?php

namespace App\Services;

interface UserServiceInterface
{
    public function create(array $arrayCheck, array $arrayInsert);

    public function findByUsername($username);
}
