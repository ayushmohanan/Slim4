<?php
declare(strict_types=1);
use App\Middleware\Auth;
#LivTours API's
$app->get('/state', App\Controller\Api\GetState::class);
$app->post('/move/{from}/{to}', App\Controller\Api\DoMove::class);
/*
$app->get('/authcrmtoken', App\Controller\Authcrm\GetAll::class);
$app->post('/authcrmtoken', App\Controller\Authcrm\Create::class);*/
