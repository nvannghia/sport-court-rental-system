<?php

namespace App\Services\Implements;

use App\Repositories\SportTypeRepositoryInterface;
use App\Services\SportTypeServiceInterface;
use phpDocumentor\Reflection\Types\Boolean;

class SportTypeServiceImplement implements SportTypeServiceInterface
{
    protected $sportTypeRepositoryInterface;

    public function __construct(SportTypeRepositoryInterface $sportTypeRepositoryInterface)
    {
        $this->sportTypeRepositoryInterface = $sportTypeRepositoryInterface;
    }

    public function getAllSportTypes()
    {
        return $this->sportTypeRepositoryInterface->getAllSportTypes();
    }

    public function addSportType(array $arrayCheck, array $arrayInsert)
    {
        return $this->sportTypeRepositoryInterface->addSportType($arrayCheck, $arrayInsert);
    }

    public function deleteSportTypeByID($sportTypeID): bool
    {
        return $this->sportTypeRepositoryInterface->deleteSportTypeByID($sportTypeID);
    }

    public function updateSportType($sportTypeID, $typeName) 
    {
        return $this->sportTypeRepositoryInterface->updateSportType($sportTypeID, $typeName);
    }
}
