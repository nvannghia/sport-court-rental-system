<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
use App\Services\SportFieldServiceInterface;
use App\Services\SportTypeServiceInterface;
use App\Utils\CaptchaUtils;

class HomeController extends Controller
{
    private $sportTypeServiceInterface;

    private $sportFieldServiceInterface;

    private const ITEM_PER_PAGE = 6;

    public function __construct(SportTypeServiceInterface $sportTypeServiceInterface, SportFieldServiceInterface $sportFieldServiceInterface)
    {
        $this->sportTypeServiceInterface = $sportTypeServiceInterface;
        $this->sportFieldServiceInterface = $sportFieldServiceInterface;
    }

    function test()
    {
        
        echo "<pre>";
        var_dump(($_SESSION['userInfo']['Role'] === 'OWNER'));
        die();
    }
    public function index()
    {
        //get sportType and quantity of each type.
        $sportTypes = $this->sportTypeServiceInterface->getAllSportTypesWithCount()->toArray();

        if (!empty($_GET) && count($_GET) > 1) { // $_GET always have the "url" data, var_dump to see

            $sportType = $_GET['sportType'] ?? null;
            $sportFieldName = $_GET['inputSportFieldName'] ?? null;
            $zoneName = $_GET['inputZoneName'] ?? null;

            //pagination
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($currentPage - 1) * self::ITEM_PER_PAGE;

            $results = $this->sportFieldServiceInterface->filterSportFieldsByConditions($offset , $sportType, $sportFieldName, $zoneName);
            $sportFields = $results['sportFields'];
            $totalPages = $results['totalPages'];

            if ($sportFields != null) {
                $sportFields = $sportFields->load('owner')->toArray();

                return $this->view('home/index', [
                    'sportTypes' => $sportTypes,
                    'sportFields' => $sportFields,
                    'totalPages' => $totalPages,
                    'currentPage' => $currentPage,
                ]);
            }

            return $this->view('home/index', [
                'sportTypes' => $sportTypes
            ]);
            
        } else {
            $this->view('home/index', [
                'sportTypes' => $sportTypes
            ]);
        }
    }
}
