<?php
declare(strict_types=1);

namespace FootShop\Brands\Repository\PDO;

use FootShop\Brands\Factory\BrandFactory;
use FootShop\Brands\Repository\BrandRepository;
use PDO;

class PDOBrandRepository implements BrandRepository
{
    /** @var PDO */
    private $pdo;

    /** @var BrandFactory */
    private $brandFactory;

    /** @var BrandArrayHydrator */
    private $brandArrayHydrator;

    public function __construct(PDO $pdo, BrandFactory $brandFactory, BrandArrayHydrator $brandArrayHydrator)
    {
        $this->pdo = $pdo;
        $this->brandFactory = $brandFactory;
        $this->brandArrayHydrator = $brandArrayHydrator;
    }

    public function findAll(): iterable
    {
        $sql = 'SELECT 
            b.id, 
            b.name 
        FROM brands b';
        $statement = $this->pdo->query($sql);

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $brand = $this->brandFactory->create();
            $this->brandArrayHydrator->hydrate($brand, $row);

            yield $brand;
        }
    }
}
