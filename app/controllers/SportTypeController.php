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

    public function addSportType()
    {
        if (!empty($_POST) && $_POST['action'] === "addSportType") {
            $typeName = $_POST['typeName'] ?? null;

            if (empty($typeName))
                echo json_encode([
                    "statusCode" => 204,
                    "message" => "Please enter a type name!"
                ]);
            else {
                $sportType = $this->sportTypeServiceInterface->addSportType(
                    ['TypeName' => $typeName],
                    ['TypeName' => $typeName]
                );

                if (!$sportType->wasRecentlyCreated) {
                    echo json_encode([
                        "statusCode" => 409,
                        "message" => "Sport type already exists!",
                        "typeName" => $sportType->TypeName
                    ]);
                } else {
                    echo json_encode([
                        "statusCode" => 200,
                        "message" => "Sport type added successfully!",
                        "sportType" => $sportType
                    ]);
                }
            }
        } else {
            echo json_encode([
                "statusCode" => 400,
                "message" => "Bad request!"
            ]);
        }
    }

    public function deleteSportTypeByID($sportTypeID)
    {
        if (!empty($sportTypeID) && is_numeric($sportTypeID)) {
            $isDeleteSuccess = $this->sportTypeServiceInterface->deleteSportTypeByID($sportTypeID);
            if ($isDeleteSuccess)
                echo json_encode([
                    "statusCode" => 200,
                    "message" => "Sport Type Deleted!"
                ]);
            else
                echo json_encode([
                    "statusCode" => 500,
                    "message" => "Server Internal Error!"
                ]);
        } else {
            echo json_encode([
                "statusCode" => 400,
                "message" => "Invalid data type for sportTypeID. Expected a numeric value."
            ]);
        }
    }

    public function updateSportType()
    {
        if (!empty($_POST) && $_POST['action'] === "editSportType") {
            $sportTypeID = $_POST['sportTypeID']?? null;
            $typeName = $_POST['typeName']?? null;

            $sportType = $this->sportTypeServiceInterface->updateSportType($sportTypeID, $typeName);
            if ($sportType === false) {
                echo json_encode([
                    "statusCode" => 409 ,
                    "message" => "Existed Sport Type!"
                ]);
            } else {
                echo json_encode([
                    "statusCode" => 200,
                    "message" => "Sport Type Updated!",
                    "sportType" => $sportType
                ]);
            }
        } else {
            echo json_encode([
                "statusCode" => 400,
                "message" => "Bad request!"
            ]);
        }
    }

}
