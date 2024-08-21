<?php

namespace App\Services;

interface FieldOwnerServiceInterface
{
    function createBusiness(array $array);

    public function isOwnerRegistered($id);

    public function getAllOwners();

    public function updateOwnerStatus($ownerID);

    public function getFieldOwnerByOwnerID($ownerID);
}
