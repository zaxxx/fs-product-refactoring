<?php
declare(strict_types=1);

namespace FootShop\Products\Repository;

use FootShop\Products\Entity\Product;

interface ProductRepository
{
    /**
     * @param ProductsQuery $query
     * @return iterable|Product[]
     */
    public function find(ProductsQuery $query): iterable;
}
