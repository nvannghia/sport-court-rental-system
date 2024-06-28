<?php

namespace App\Repositories\Implements;

use App\Models\SportField;
use App\Repositories\SportFieldRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SportFieldRepositoryImplement implements SportFieldRepositoryInterface
{
    public function create(array $arrayCheck, array $arrayInsert): sportField
    {
        return SportField::firstOrCreate($arrayCheck, $arrayInsert);
    }

    public function getSportFieldByOwnerID($owerID): Collection
    {
        return SportField::where('OwnerID', $owerID)
            ->with(['sportType']) // fetching relationship: eager loading
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getSportFieldByID($sportFieldID)
    {
        return SportField::find($sportFieldID);
    }

    public function update($sportFieldID, array $attributes)
    {
        $sportField = $this->getSportFieldByID($sportFieldID);

        if ($sportField) {

            $sportField->fill($attributes);

            $isUpdated = $sportField->save();

            if ($isUpdated)
                return $sportField;
            
            return null;
        }

        return null;
    }

    public function destroy($sportFieldID)
    {
        return SportField::destroy($sportFieldID);
    }
}
