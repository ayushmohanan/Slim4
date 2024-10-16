<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Slim\Route;

final class Auth extends Base
{
    public function __invoke(Request $request, RequestHandler $handler): Response{

        echo '<pre>';
        print_r($request);exit();

        $jwtHeader = $request->getHeaderLine('Authorization');
        if (! $jwtHeader) {

            throw new \App\Exception\Auth('JWT Token required.', 400);
        }
        $jwt = explode('Bearer ', $jwtHeader);
        if (! isset($jwt[1])) {

            throw new \App\Exception\Auth('JWT Token invalid.', 400);
        }

        $decoded = $this->checkToken($jwt[1]);    
        $object['decoded'] = $decoded;
        $request = $request->withParsedBody($object);  
       
        return $handler->handle($request);
        #$object = (array) $request->getParsedBody();
        #$object['decoded'] = $decoded;
        #return $next($request->withParsedBody($object), $response);
    }
}
