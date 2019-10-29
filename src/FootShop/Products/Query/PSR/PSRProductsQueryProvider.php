<?php
declare(strict_types=1);

namespace FootShop\Products\Query\PSR;

use FootShop\Products\Query\ProductsQuery;
use FootShop\Products\Query\ProductsQueryProvider;
use Psr\Http\Message\ServerRequestInterface;

class PSRProductsQueryProvider implements ProductsQueryProvider
{
    /** @var ServerRequestInterface */
    private $request;

    /** @var ProductsQuery|null */
    private $query;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function get(): ProductsQuery
    {
        if ($this->query !== null) {
            return $this->query;
        }

        $queryParams = $this->request->getQueryParams();

        $this->query = new ProductsQuery();

        if (array_key_exists('name', $queryParams)) {
            $this->query->setName((string)$queryParams['name']);
        }

        if (array_key_exists('brand', $queryParams)) {
            $this->query->setBrandId((int)$queryParams['brand']);
        }

        if (array_key_exists('order', $queryParams)) {
            $this->query->setOrder((string)$queryParams['order']);
        }

        if (array_key_exists('limit', $queryParams)) {
            $this->query->setLimit((int)$queryParams['limit']);
        }

        return $this->query;
    }
}
