<?php

namespace App\Services\Implements;

use App\Repositories\FieldOwnerRepositoryInterface;
use App\Services\FieldOwnerServiceInterface;

class FieldOwnerServiceImplement implements FieldOwnerServiceInterface
{
    protected $fieldOwnerRepositoryInterface;

    public function __construct(FieldOwnerRepositoryInterface $fieldOwnerRepositoryInterface)
    {
        $this->fieldOwnerRepositoryInterface = $fieldOwnerRepositoryInterface;
    }

    public function createBusiness(array $array)
    {
        return $this->fieldOwnerRepositoryInterface->createBusiness($array);
    }

    public function isOwnerRegistered($id)
    {
        return $this->fieldOwnerRepositoryInterface->isOwnerRegistered($id);
    }

    public function getAllOwners()
    {
        return $this->fieldOwnerRepositoryInterface->getAllOwners();
    }

    public function updateOwnerStatus($ownerID)
    {
        return $this->fieldOwnerRepositoryInterface->updateOwnerStatus($ownerID);
    }
}
