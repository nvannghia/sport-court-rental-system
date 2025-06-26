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

    public function getSportFieldByOwnerID($offset, $owerID)
    {
        return $this->sportFieldRepositoryInterface->getSportFieldByOwnerID($offset, $owerID);
    }

    public function getSportFieldByOwnerIDWithFilter($ownerID, $filter)
    {
        return $this->sportFieldRepositoryInterface->getSportFieldByOwnerIDWithFilter($ownerID, $filter);
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

    public function filterSportFieldsByConditions($offset, $sportType = null,  $fieldName = null, $zoneName = null)
    {
        return $this->sportFieldRepositoryInterface->filterSportFieldsByConditions($offset, $sportType,  $fieldName, $zoneName);
    }

    public function getSportFieldByIDWithReviews($offset, $orderBy, $sportFieldID)
    {
        return $this->sportFieldRepositoryInterface->getSportFieldByIDWithReviews($offset, $orderBy, $sportFieldID);
    }

    public function getPagination($offset, $owerID) 
    {
        return $this->sportFieldRepositoryInterface->getPagination($offset, $owerID);
    }

    public function getSportFieldByTypePagination($offset, $sportTypeId, $fieldName, $area) 
    {
        return $this->sportFieldRepositoryInterface->getSportFieldByTypePagination($offset, $sportTypeId, $fieldName, $area);
    }
}
