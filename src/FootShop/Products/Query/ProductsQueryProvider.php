<?php
declare(strict_types=1);

namespace FootShop\Products\Query;

interface ProductsQueryProvider
{
    public function get(): ProductsQuery;
}
