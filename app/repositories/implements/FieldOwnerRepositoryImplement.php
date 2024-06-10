<?php

namespace App\Repositories\Implements;

use App\Models\FieldOwner;
use App\Models\UserModel;
use App\Repositories\FieldOwnerRepositoryInterface;
use Illuminate\Database\Capsule\Manager as Capsule;


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

    public function getAllOwners()
    {
        return FieldOwner::all();
    }

    public function updateOwnerStatus($ownerID)
    {
        try {
            Capsule::beginTransaction();

            //update role of user with owerID 
            $user = UserModel::find($ownerID);
            if ($user) {
                $user->Role = ($user->Role === "CUSTOMER") ? "OWNER" : "CUSTOMER";
                $user->save();
            }

            $fieldOwner = FieldOwner::where("OwnerID", $ownerID)->first(); // get first records
            if ($fieldOwner) {
                $fieldOwner->Status = ($fieldOwner->Status === "INACTIVE") ? "ACTIVE" : "INACTIVE";
                $fieldOwner->save();
            }

            Capsule::commit();

            return  $fieldOwner = $fieldOwner->fresh();
        } catch (\PDOException $e) {
            echo "Exception: " . $e->getMessage();
            Capsule::rollBack();

            return false;
        }
    }
}
