<?php
declare(strict_types=1);

use Hafo\DI\Container;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequestFactory;

return [

    PDO::class => function (Container $container) {
        $config = $container->get('db');
        $pdo = new PDO(
            'mysql:host=' . $config['server'] . ';port=3306;dbname=' . $config['database'],
            $config['user'],
            $config['password']
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        $pdo->query('SET NAMES utf8');
        $pdo->query('SET CHARACTER SET utf8');

        return $pdo;
    },

    Twig_Loader_Filesystem::class => function (Container $container) {
        return new Twig_Loader_Filesystem(__DIR__ . '/../templates');
    },

    Twig_Environment::class => function (Container $container) {
        return new Twig_Environment($container->get(Twig_Loader_Filesystem::class));
    },

    Logger::class => function (Container $container) {
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler(__DIR__ . '/../var/logs/main.log', Logger::DEBUG));

        return $log;
    },

    ServerRequestInterface::class => function (Container $container) {
        return ServerRequestFactory::fromGlobals();
    },

];
