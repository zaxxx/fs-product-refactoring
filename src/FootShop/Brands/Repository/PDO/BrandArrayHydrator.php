<?php
declare(strict_types=1);

namespace FootShop\Brands\Repository\PDO;

use Assert\Assertion;
use FootShop\Brands\Entity\Brand;

class BrandArrayHydrator
{
    public function hydrate(Brand $brand, array $data): void
    {
        Assertion::keyExists($data, 'id');
        Assertion::keyExists($data, 'name');

        $brand->setId((int)$data['id']);
        $brand->setName((string)$data['name']);
    }
}
