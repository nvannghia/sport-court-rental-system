<?php

namespace App\Services\Implements;

use App\Repositories\SportFieldRepositoryInterface;
use App\Services\SportFieldServiceInterface;
use App\Services\SportTypeServiceInterface;

class SportFieldServiceImplement implements SportFieldServiceInterface
{
    private $sportFieldRepositoryInterface;

    public function __construct(SportFieldRepositoryInterface $sportFieldRepositoryInterface)
    {
        $this->sportFieldRepositoryInterface = $sportFieldRepositoryInterface;
    }
    public function create(array $arrayCheck, array $arrayInsert)
    {
        return $this->sportFieldRepositoryInterface->create($arrayCheck, $arrayInsert);
    }

    public function getSportFieldByOwnerID($owerID)
    {
        return $this->sportFieldRepositoryInterface->getSportFieldByOwnerID($owerID);
    }

    public function getSportFieldByID($sportFieldID) 
    {
        return $this->sportFieldRepositoryInterface->getSportFieldByID($sportFieldID);
    }

    public function update($sportFieldID, array $attributes)
    {
        return $this->sportFieldRepositoryInterface->update($sportFieldID, $attributes);
    }

    public function destroy($sportFieldID)
    {
        return $this->sportFieldRepositoryInterface->destroy($sportFieldID);
    }
}
