<?php

namespace App\Services\Implements;

use App\Repositories\SportTypeRepositoryInterface;
use App\Services\SportTypeServiceInterface;

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
}
