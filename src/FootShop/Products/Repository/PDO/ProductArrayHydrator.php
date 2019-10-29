<?php
declare(strict_types=1);

namespace FootShop\Products\Repository\PDO;

use Assert\Assertion;
use FootShop\Products\Entity\Product;

class ProductArrayHydrator
{
    public function hydrate(Product $product, array $data): void
    {
        Assertion::keyExists($data, 'id');
        Assertion::keyExists($data, 'name');
        Assertion::keyExists($data, 'color');
        Assertion::keyExists($data, 'price');
        Assertion::keyExists($data, 'quantity');
        Assertion::keyExists($data, 'reserved');

        $product->setId((int)$data['id']);
        $product->setName((string)$data['name']);
        $product->setColor((string)$data['color']);
        $product->setPrice((float)$data['price']);
        $product->setBrandId(array_key_exists('brand_id', $data) ? (int)$data['brand_id'] : null);
        $product->setBrandName(array_key_exists('brand', $data) ? (string)$data['brand'] : null);
        $product->setQuantity((int)$data['quantity']);
        $product->setReserved((int)$data['reserved']);
    }
}
