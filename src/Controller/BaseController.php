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
    // Declare the properties
    protected Client $client;
    protected string $HeaderCookie;
    protected string $SessionID;
    protected string $AcceptType;
    public function __construct(Container $container)
    {
        $this->container = $container;
        // Guzzle Request
        $client = new Client(['timeout' => 10000.0]);
        $this->client = $client;
        // Initialize other properties
        $this->HeaderCookie = 'JSESSIONID=DB14D5E018CEF06BBDC3BB2CC46CF629.tomcat9_1';
        $this->SessionID = 'E388021410FB3AABA495E917239D950B.tomcat9_1';
        $this->AcceptType = 'application/json';
    }
}
