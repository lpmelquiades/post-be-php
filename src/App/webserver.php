<?php

use App\Dependency;
use Post\Input\PostAction;
use Post\Input\QuoteAction;

require_once __DIR__ . '/../../vendor/autoload.php';

$dependency = new Dependency();
$app = \DI\Bridge\Slim\Bridge::create($dependency->container);
$app->addRoutingMiddleware();

// $app->addErrorMiddleware(true, true, true);

$app->post('/post', PostAction::class);
$app->post('/quote', QuoteAction::class);
$app->run();
