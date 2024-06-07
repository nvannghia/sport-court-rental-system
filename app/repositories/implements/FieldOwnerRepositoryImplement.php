<?php
namespace App\Repositories\Implements;
use App\Models\FieldOwner;
use App\Repositories\FieldOwnerRepositoryInterface;

class FieldOwnerRepositoryImplement implements FieldOwnerRepositoryInterface
{
    public function createBusiness(array $array)
    {
        return FieldOwner::create($array);
    }

    public function isOwnerRegistered($id)
    {
        return FieldOwner::where('ownerID', $id)->exists();
    }
}
