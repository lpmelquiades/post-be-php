<?php

use App\Dependency;
use Post\Input\CommandExceptionCatch;
use Post\Input\CountAction;
use Post\Input\GetPostAction;
use Post\Input\NotFoundExceptionCatch;
use Post\Input\PostAction;
use Post\Input\QueryExceptionCatch;
use Post\Input\QuoteAction;
use Post\Input\RepostAction;
use Post\Input\RequestResponseLogging;
use Post\Input\SearchAction;
use User\Input\GetUserAction;

require_once __DIR__ . '/../../vendor/autoload.php';

$dependency = new Dependency();
$app = \DI\Bridge\Slim\Bridge::create($dependency->container);
$app->addRoutingMiddleware();

$app->add(NotFoundExceptionCatch::class);
$app->add(RequestResponseLogging::class);

// Supports [RQ-04]-[RQ-07]-[RQ-09].
$app->post('/post', PostAction::class)->add(CommandExceptionCatch::class);

// Supports [RQ-09]
$app->post('/quote', QuoteAction::class)->add(CommandExceptionCatch::class);

// Supports [RQ-09]
$app->post('/repost', RepostAction::class)->add(CommandExceptionCatch::class);


// Supports [RQ-01]-[RQ-02]-[RQ-03].
$app->get('/posts', SearchAction::class)->add(QueryExceptionCatch::class);

// Supports [RQ-01]-[RQ-02]-[RQ-03]-[RQ-05]-[RQ-06].
$app->get('/posts/count', CountAction::class)->add(QueryExceptionCatch::class);

// Supports [RQ-01]-[RQ-02]-[RQ-03]-[RQ-05]-[RQ-06].
$app->get('/post/{id}', GetPostAction::class)->add(QueryExceptionCatch::class);

// Supports [RQ-05]-[RQ-08]-[RQ-09].
$app->get('/user/{username}', GetUserAction::class)->add(QueryExceptionCatch::class);


$app->run();
