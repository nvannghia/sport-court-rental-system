<?php

use App\Services\Implements\BookingServiceImplement;
use App\Services\Implements\FieldOwnerServiceImplement;
use App\Services\Implements\FieldReviewServiceImplement;
use App\Services\Implements\InvoiceServiceImplement;
use App\Services\Implements\SportFieldServiceImplement;
use App\Services\Implements\SportTypeServiceImplement;
use App\Services\Implements\StatisticsServiceImplement;
use App\Services\Implements\UserServiceImplement;
use App\Utils\CloudinaryService;
use App\Utils\SendMessageViaSMS;

class App
{
    protected $controller = "home";

    protected $method = "index";

    protected $params = [];

    protected $container;



    protected $controllersWithDependencies = [
        'HomeController' => [
            SportTypeServiceImplement::class,
            SportFieldServiceImplement::class,
        ],
        'UserController' => [
            UserServiceImplement::class,
            SendMessageViaSMS::class,
            SportTypeServiceImplement::class,
            SportFieldServiceImplement::class,
            CloudinaryService::class,
        ],
        'FieldOwnerController' => [
            FieldOwnerServiceImplement::class,
            SendMessageViaSMS::class
        ],
        'SportFieldController' => [
            SportFieldServiceImplement::class,
            SportTypeServiceImplement::class,
            CloudinaryService::class,
            FieldReviewServiceImplement::class,
        ],
        'SportTypeController' => [SportTypeServiceImplement::class],
        'FieldReviewController' => [
            FieldReviewServiceImplement::class,
            CloudinaryService::class,
        ],
        'BookingController' => [
            BookingServiceImplement::class,
            SportFieldServiceImplement::class,
        ],
        'InvoiceController' => [
            BookingServiceImplement::class,
            InvoiceServiceImplement::class,
        ],
        'StatisticalController' => [
            SportFieldServiceImplement::class,
            BookingServiceImplement::class,
            StatisticsServiceImplement::class,
            FieldOwnerServiceImplement::class,
        ]
    ];

    protected $controllerMapping = [
        'home' => 'HomeController',
        'user' => 'UserController',
        'fieldowner' => 'FieldOwnerController',
        'sportfield' => 'SportFieldController',
        'sporttype' => 'SportTypeController',
        'fieldreview' => 'FieldReviewController',
        'booking' => 'BookingController',
        'invoice' => 'InvoiceController',
        'statistical' => 'StatisticalController',
    ];

    /*
        url: []
        url[0]: controller name
        url[1]: method name inside controller
        url[2...n]: parameters
    */
    public function __construct($container)
    {

        $this->container = $container; // DI

        $url = $this->parseURL();

        if (isset($url[0])) {

            $this->controller = $this->controllerMapping[$url[0]];

            if (file_exists("../app/controllers/" . $this->controller . ".php")) {
                unset($url[0]);
            }
        } else 
            $this->controller = $this->controllerMapping['home']; // home controller for first time visit website

        require_once '../app/controllers/' . ($this->controller) . '.php';

        if (isset($this->controllersWithDependencies[$this->controller])) {
            $controllerClass = $this->controller;

            $dependencies = $this->controllersWithDependencies[$this->controller];

            $dependencyInstances = array_map(function ($dependency) {
                return $this->container->get($dependency);
            }, $dependencies);

            $reflection = new \ReflectionClass($controllerClass); // khởi tạo class ...controller
            $this->controller = $reflection->newInstanceArgs($dependencyInstances); // tạo và truyền tham số cho class, sau đó gán lại
        } else {
            $this->controller = new $this->controller();
        }


        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            $urlTrim = rtrim($_GET['url'], '/');
            $urlExplode = explode('/', filter_var($urlTrim, FILTER_SANITIZE_URL));
            return $urlExplode;
        }
    }
}
