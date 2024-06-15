<?php

namespace App\Repositories\Implements;

use App\Models\SportType;
use App\Repositories\SportTypeRepositoryInterface;

class SportTypeRepositoryImplement implements SportTypeRepositoryInterface
{
    public function getAllSportTypes()
    {
        return SportType::all();
    }

    public function addSportType(array $arrayCheck, array $arrayInsert)
    {
        return SportType::firstOrCreate($arrayCheck, $arrayInsert);
    }

    public function deleteSportTypeByID($sportTypeID) 
    {
        return SportType::destroy($sportTypeID);
    }

    public function updateSportType($sportTypeID, $typeName)
    {
        $sportType = SportType::where('TypeName', $typeName)->first();
        if ($sportType) {
            return false;
        }

        $sportType = SportType::find($sportTypeID);
        if ($sportType) {
            $sportType->TypeName = $typeName;
            $sportType->save();
            
            return $sportType->fresh();
        }
        
    }
}
