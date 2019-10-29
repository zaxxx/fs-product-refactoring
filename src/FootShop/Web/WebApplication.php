<?php
declare(strict_types=1);

namespace FootShop\web;

use FootShop\Web\Controller\Controller;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Throwable;
use Twig_Environment;

class WebApplication
{
    /** @var ContainerInterface */
    private $container;

    /** @var Router */
    private $router;

    /** @var Logger */
    private $logger;

    /** @var Twig_Environment */
    private $twig;

    public function __construct(
        ContainerInterface $container,
        Router $router,
        Logger $logger,
        Twig_Environment $twig
    ) {
        $this->container = $container;
        $this->router = $router;
        $this->logger = $logger;
        $this->twig = $twig;
    }

    public function run(): void
    {
        $controllerClass = $this->router->getControllerClass();
        /** @var Controller $controller */
        $controller = $this->container->get($controllerClass);

        try {
            $controller->render();
        } catch (Throwable $e) {
            $this->logger->critical($e->getMessage());
            echo $this->twig->render('error.html');
        }
    }
}
