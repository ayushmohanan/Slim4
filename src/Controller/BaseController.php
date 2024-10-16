<?php
declare(strict_types=1);
namespace App\Controller;
use GuzzleHttp\Client;
use App\Helper\JsonResponse;
use Pimple\Psr11\Container;
use App\Service\BaseControllerService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
abstract class BaseController
{
    protected Container $container;
    public function __construct(Container $container)
    {
        $this->container = $container;
        #Guzzile Request
        #$client = new Client();
        $baseAuthURL    = (string)('#');
        $baseServiceURL = (string)('#');
        $client = new Client(['timeout'  => 10000.0]);
        $this->baseAuthUrl = $baseAuthURL;
        $this->baseUrl = $baseServiceURL;
        $this->client = $client;
        $this->HeaderCookie = 'JSESSIONID=DB14D5E018CEF06BBDC3BB2CC46CF629.tomcat9_1';
        $this->SessionID    = 'E388021410FB3AABA495E917239D950B.tomcat9_1';
        $this->AcceptType = 'application/json';
    }
    protected function getRequestToken(): BaseControllerService
    {
        return $this->container->get('basecontroller_service');
    }
}
