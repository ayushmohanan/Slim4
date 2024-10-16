<?php

declare(strict_types=1);

namespace App\Helper;

use Psr\Http\Message\ResponseInterface as Response;

final class JsonResponse
{
    public static function withJson(
        Response $response,
        string $data,
        int $status = 200
    ): Response {
        $response->getBody()->write($data);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }

    #CRM request 
    public static function withJsonCrm(
        Response $response,
        string $data,
        int $status = 200         
    ): Response {
        $response->getBody()->write($data);

        return $response
                ->withHeader('Content-Type', 'application/json')
                ->withAddedHeader('access_token', 'knq1QQ9CcvFLRlcu8dXPjXGT8GaO^pHUkWL55CxPS8ph33Y71LtAc4R4rfqAT*OZ!n.WvMCfWsbugE6pl2Dp8FNZYbKZPot2bLtWF2fb*^^HSgpQQV5xaCKrDYlSTJooyw8oUopKcoTs*YYNpJlB8nAldiIcOb0XxVozD2fpOB9qPVQ7*^I7cncszNZFRoSjGxecT3iIJybEj6To2fAKh0FU6ZZjlADFUhnTj^m3cI2*EU=!n.qKUFa^znrjyno5pyZKVXrbBY74jiIpK4PHKRoJhh9QY=!n')
                ->withStatus($status);
    }
}
