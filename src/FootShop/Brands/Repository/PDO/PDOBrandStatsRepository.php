<?php
declare(strict_types=1);

namespace FootShop\Brands\Repository\PDO;

use FootShop\Brands\Factory\BrandStatsFactory;
use FootShop\Brands\Repository\BrandStatsRepository;
use PDO;

class PDOBrandStatsRepository implements BrandStatsRepository
{
    /** @var PDO */
    private $pdo;

    /** @var BrandStatsFactory */
    private $brandStatsFactory;

    /** @var BrandStatsArrayHydrator */
    private $brandStatsArrayHydrator;

    public function __construct(
        PDO $pdo,
        BrandStatsFactory $brandStatsFactory,
        BrandStatsArrayHydrator $brandStatsArrayHydrator
    ) {
        $this->pdo = $pdo;
        $this->brandStatsFactory = $brandStatsFactory;
        $this->brandStatsArrayHydrator = $brandStatsArrayHydrator;
    }

    public function findAll(): iterable
    {
        $sql = 'SELECT 
            b.name, 
            SUM(p.quantity) AS quantity, 
            SUM(p.reserved) AS reserved, 
            SUM(p.quantity * p.price) AS price_quantity, 
            SUM(p.reserved * p.price) AS price_reserved
        FROM brands b
        LEFT JOIN products p on b.id = p.brand_id
        GROUP BY b.id
        ORDER BY b.name';
        $statement = $this->pdo->query($sql);

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $brandStats = $this->brandStatsFactory->create();
            $this->brandStatsArrayHydrator->hydrate($brandStats, $row);

            yield $brandStats;
        }
    }
}
