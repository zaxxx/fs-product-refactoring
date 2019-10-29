<?php
declare(strict_types=1);

namespace FootShop\Brands\Factory;

use FootShop\Brands\Entity\Brand;

class BrandFactory
{
    public function create(): Brand
    {
        return new Brand();
    }
}
