<?php

namespace App\Services;

interface SportFieldServiceInterface
{
    public function create(array $arrayCheck, array $arrayInsert);

    public function getSportFieldByOwnerID($offset, $owerID);

    public function getSportFieldByOwnerIDWithFilter($ownerID, $filter);

    public function getSportFieldByID($sportFieldID);

    public function getSportFieldByIDWithReviews($offset, $orderBy, $sportFieldID);

    public function update($sportFieldID, array $attributes);

    public function destroy($sportFieldID);

    public function filterSportFieldsByConditions($offset ,$sportType = null,  $fieldName = null, $zoneName = null);
}
