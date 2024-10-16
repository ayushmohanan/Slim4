<?php
declare(strict_types=1);
use Slim\App;
return function (App $app) {
    // Middleware to start sessions
    $app->add(function ($request, $handler) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return $handler->handle($request);
    });
};
