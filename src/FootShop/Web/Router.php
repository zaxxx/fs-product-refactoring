<?php
declare(strict_types=1);

namespace FootShop\Web;

use FootShop\web\Controller\ProductController;
use FootShop\web\Controller\StatsController;
use Psr\Http\Message\ServerRequestInterface;

class Router
{
    /** @var ServerRequestInterface */
    private $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function getControllerClass(): string
    {
        $queryParams = $this->request->getQueryParams();

        if (isset($queryParams['type']) && $queryParams['type'] === 'stats') {
            return StatsController::class;
        }

        return ProductController::class;
    }
}
