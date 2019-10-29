<?php
declare(strict_types=1);

namespace FootShop\Brands\Repository;

use FootShop\Brands\Entity\BrandStats;

interface BrandStatsRepository
{
    /** @return iterable|BrandStats[] */
    public function findAll(): iterable;
}
