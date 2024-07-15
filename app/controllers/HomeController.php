<?php

use App\Models\SportField;
use App\Services\SportFieldServiceInterface;
use App\Services\SportTypeServiceInterface;

class HomeController extends Controller
{

    private $sportTypeServiceInterface;

    private $sportFieldServiceInterface;

    public function __construct(SportTypeServiceInterface $sportTypeServiceInterface, SportFieldServiceInterface $sportFieldServiceInterface)
    {
        $this->sportTypeServiceInterface = $sportTypeServiceInterface;
        $this->sportFieldServiceInterface = $sportFieldServiceInterface;
    }

    public function test()
    {
        $sportType = 108;
        $sportFieldName = $_GET['inputSportFieldName'] ?? null;
        $zoneName = $_GET['inputZoneName'] ?? null;
        var_dump($this->sportFieldServiceInterface->filterSportFieldsByConditions($sportType, $sportFieldName, $zoneName));
    }
    public function index()
    {
        //get sportType and quantity of each type.
        $sportTypes = $this->sportTypeServiceInterface->getAllSportTypesWithCount()->toArray();

        if (!empty($_GET)) {

            $sportType = $_GET['sportType'] ?? null;
            $sportFieldName = $_GET['inputSportFieldName'] ?? null;
            $zoneName = $_GET['inputZoneName'] ?? null;

            $sportFields = $this->sportFieldServiceInterface->filterSportFieldsByConditions($sportType, $sportFieldName, $zoneName);

            if ($sportFields != null) {
                $sportFields = $sportFields->load('owner')->toArray();

                $this->view('home/index', [
                    'sportTypes' => $sportTypes,
                    'sportFields' => $sportFields
                ]);

                return;
            }

            $this->view('home/index', [
                'sportTypes' => $sportTypes
            ]);
            
            return;
        } else {
            $this->view('home/index', [
                'sportTypes' => $sportTypes
            ]);
        }
    }
}
