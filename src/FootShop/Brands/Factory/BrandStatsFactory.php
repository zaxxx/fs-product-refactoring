<?php
declare(strict_types=1);

namespace FootShop\Brands\Factory;

use FootShop\Brands\Entity\BrandStats;

class BrandStatsFactory
{
    public function create(): BrandStats
    {
        return new BrandStats();
    }
}
