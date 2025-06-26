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
    }
    public function index()
    {
        //get sportType and quantity of each type.
        $sportTypes = $this->sportTypeServiceInterface->getAllSportTypesWithCount()->toArray();
        return $this->view('home/index', [
            'sportTypes' => $sportTypes
        ]);
    }

    public function getPaginatedSportFieldsForHomepage()
    {
        header('Content-Type: application/json');

        $fieldName   = $_GET['fieldName'] ?? null;
        $area        = $_GET['area'] ?? null;
        $sportTypeId = $_GET['sportTypeId'] ?? null;
        if (!$sportTypeId || !is_numeric($sportTypeId)) {
            http_response_code(400);
            echo json_encode([
                'statusCode' => 400,
                'message'    => "Missing required field: 'sportTypeId'"
            ]);
            exit();
        }

        $page        = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $offset      = ($page - 1) * self::ITEM_PER_PAGE;
        $rs          = $this->sportFieldServiceInterface->getSportFieldByTypePagination($offset, $sportTypeId, $fieldName, $area);
        $totalPages  = !empty($rs) ? $rs['totalPages'] : [];
        $sportFields = !empty($rs) ? $rs['items'] : [];

        echo json_encode([
            'items' => $sportFields,
            'pagination' => [
                'current'    => $page,
                'totalPages' => $totalPages
            ]
        ]);
    }
}
