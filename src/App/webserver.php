<?php

use App\Dependency;
use Post\Input\CommandExceptionCatch;
use Post\Input\CountAction;
use Post\Input\GetPostAction;
use Post\Input\GetUserAction;
use Post\Input\NotFoundExceptionCatch;
use Post\Input\PostAction;
use Post\Input\QueryExceptionCatch;
use Post\Input\QuoteAction;
use Post\Input\RepostAction;
use Post\Input\RequestResponseLogging;
use Post\Input\SearchAction;
use Post\Input\UserAuth;

require_once __DIR__ . '/../../vendor/autoload.php';

$dependency = new Dependency();
$app = \DI\Bridge\Slim\Bridge::create($dependency->container);
$app->addRoutingMiddleware();

$app->add(NotFoundExceptionCatch::class);
$app->add(RequestResponseLogging::class);
// $app->addErrorMiddleware(true, true, true);

$app->post('/post', PostAction::class)->add(CommandExceptionCatch::class);
$app->post('/quote', QuoteAction::class)->add(CommandExceptionCatch::class);
$app->post('/repost', RepostAction::class)->add(CommandExceptionCatch::class);
$app->get('/posts', SearchAction::class)->add(QueryExceptionCatch::class);

$app->get('/posts/count', CountAction::class)->add(QueryExceptionCatch::class);
$app->get('/post/{id}', GetPostAction::class)->add(QueryExceptionCatch::class);
$app->get('/user/{username}', GetUserAction::class)->add(QueryExceptionCatch::class);
$app->run();
