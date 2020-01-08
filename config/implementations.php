<?php
declare(strict_types=1);

use FootShop\Brands\Repository\BrandRepository;
use FootShop\Brands\Repository\BrandStatsRepository;
use FootShop\Brands\Repository\PDO\PDOBrandRepository;
use FootShop\Brands\Repository\PDO\PDOBrandStatsRepository;
use FootShop\Products\Query\ProductsQueryProvider;
use FootShop\Products\Query\PSR\PSRProductsQueryProvider;
use FootShop\Products\Repository\PDO\PDOProductRepository;
use FootShop\Products\Repository\ProductRepository;

return [
    BrandRepository::class => PDOBrandRepository::class,
    BrandStatsRepository::class => PDOBrandStatsRepository::class,
    ProductRepository::class => PDOProductRepository::class,
    ProductsQueryProvider::class => PSRProductsQueryProvider::class,
];
