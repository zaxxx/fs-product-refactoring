<?php
declare(strict_types=1);

namespace FootShop\Brands\Repository\PDO;

use Assert\Assertion;
use FootShop\Brands\Entity\BrandStats;

class BrandStatsArrayHydrator
{
    public function hydrate(BrandStats $stats, array $data): void
    {
        Assertion::keyExists($data, 'name');

        $stats->setName((string)$data['name']);
        $stats->setQuantity(array_key_exists('quantity', $data) ? (int)$data['quantity'] : 0);
        $stats->setReserved(array_key_exists('reserved', $data) ? (int)$data['reserved'] : 0);
        $stats->setPriceQuantity(array_key_exists('price_quantity', $data) ? (int)$data['price_quantity'] : 0);
        $stats->setPriceReserved(array_key_exists('price_reserved', $data) ? (int)$data['price_reserved'] : 0);
    }
}
