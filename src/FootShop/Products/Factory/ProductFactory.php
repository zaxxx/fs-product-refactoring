<?php
declare(strict_types=1);

namespace FootShop\Products\Factory;

use FootShop\Products\Entity\Product;

class ProductFactory
{
    public function create(): Product
    {
        return new Product();
    }
}
