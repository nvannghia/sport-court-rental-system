<?php

namespace App\Services;

interface SportFieldServiceInterface
{
    public function create(array $arrayCheck, array $arrayInsert);

    public function getSportFieldByOwnerID($owerID);

    public function getSportFieldByID($sportFieldID);
}
