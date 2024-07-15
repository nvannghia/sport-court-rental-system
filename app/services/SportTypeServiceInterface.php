<?php

namespace App\Services;

interface SportTypeServiceInterface
{
    public function getAllSportTypes();

    public function getAllSportTypesWithCount();

    public function addSportType(array $arrayCheck, array $arrayInsert);

    public function deleteSportTypeByID($sportTypeID);

    public function updateSportType($sportTypeID, $typeName);

}
