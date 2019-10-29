<?php
declare(strict_types=1);

namespace FootShop\Brands\Repository;

use FootShop\Brands\Entity\Brand;

interface BrandRepository
{
    /** @return iterable|Brand[] */
    public function findAll(): iterable;
}
