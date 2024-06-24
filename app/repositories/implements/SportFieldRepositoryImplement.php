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
            ->with(['sportType']) // fetch relationship: eager loading
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getSportFieldByID($sportFieldID)
    {
        return SportField::find($sportFieldID);
    }
}
