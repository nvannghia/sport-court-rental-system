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
}

?>