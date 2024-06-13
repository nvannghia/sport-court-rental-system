<?php

use App\Models\SportType;
use App\Services\SportTypeServiceInterface;

class SportTypeController extends Controller
{
    private $sportTypeServiceInterface;

    public function __construct(SportTypeServiceInterface $sportTypeServiceInterface)
    {
        $this->sportTypeServiceInterface = $sportTypeServiceInterface;
    }

    public function getAllSportTypes()
    {
        if (!empty($_POST) && $_POST['action'] === "getAllSportTypes") {
            $sportTypes = $this->sportTypeServiceInterface->getAllSportTypes();

            if (count($sportTypes) > 0)
                echo json_encode([
                    "statusCode" => 200,
                    "sportTypes" => $sportTypes
                ]);
            else
                echo json_encode([
                    "statusCode" => 204,
                    "message" => "No records found"
                ]);
        }
    }
}
