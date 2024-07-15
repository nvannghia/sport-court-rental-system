<?php

namespace App\Repositories;

interface SportTypeRepositoryInterface
{
    public function getAllSportTypes();

    public function getAllSportTypesWithCount();

    public function addSportType(array $arrayCheck, array $arrayInsert);

    public function deleteSportTypeByID($sportTypeID);

    public function updateSportType($sportTypeID, $typeName);

}
