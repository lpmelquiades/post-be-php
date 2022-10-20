<?php

declare(strict_types=1);

namespace App;

use DI\Container;
use DI\ContainerBuilder;
use DI\Definition\Helper\FactoryDefinitionHelper;
use Post\CommandModel\LoadPort;
use Post\CommandModel\PersistencePort;
use Post\Integration\MongoLoadAdapter;
use Post\Integration\MongoPersistenceAdapter;

final class Dependency
{
    public readonly Container $container;

    public function __construct()
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions([
            \MongoDB\Client::class => $this->getMongoClient(),
            LoadPort::class => $this->getLoadAdapter(),
            PersistencePort::class => $this->getPersistenceAdapter()
            // \Psr\Log\LoggerInterface::class =>$this->getMonolog() 
        ]);
        $this->container = $containerBuilder->build();
    }

    private function getMongoClient(): FactoryDefinitionHelper
    {
        return \DI\factory(function (): \MongoDB\Client {
            return new \MongoDB\Client('mongodb://root:rootpass@localhost:27017/?retryWrites=false');
        });
    }

    private function getLoadAdapter(): FactoryDefinitionHelper
    {
        return \DI\factory(function (Container $c): LoadPort {
            return new MongoLoadAdapter($c->get(\MongoDB\Client::class));
        });
    }

    private function getPersistenceAdapter(): FactoryDefinitionHelper
    {
        return \DI\factory(function (Container $c): PersistencePort {
            return new MongoPersistenceAdapter($c->get(\MongoDB\Client::class));
        });
    }

    // private function getMonolog(): FactoryDefinitionHelper {
    //     return \DI\factory(function () {
    //         $logger = new Logger('mylog');
    
    //         $fileHandler = new StreamHandler(fopen('php://stdout', 'w'), Level::Info);
    //         $fileHandler->setFormatter(new LineFormatter());
    //         $logger->pushHandler($fileHandler);
    
    //         return $logger;
    //     });
    // }
}
