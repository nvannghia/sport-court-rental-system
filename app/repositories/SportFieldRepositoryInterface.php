<?php

namespace App\Repositories;

interface SportFieldRepositoryInterface
{
    public function create(array $arrayCheck, array $arrayInsert);

    public function getSportFieldByOwnerID($owerID);

    public function getSportFieldByID($sportFieldID);
}
