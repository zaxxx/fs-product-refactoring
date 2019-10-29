<?php
declare(strict_types=1);

namespace Tests\Unit\FootShop\Brands\Repository\PDO;

use FootShop\Brands\Entity\BrandStats;
use FootShop\Brands\Factory\BrandStatsFactory;
use FootShop\Brands\Repository\PDO\BrandStatsArrayHydrator;
use FootShop\Brands\Repository\PDO\PDOBrandStatsRepository;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class PDOBrandStatsRepositoryTest extends TestCase
{
    public function testFindAll(): void
    {
        $pdoStatement = $this->createMock(PDOStatement::class);
        $pdoStatement->expects(self::exactly(3))
            ->method('fetch')
            ->willReturnOnConsecutiveCalls(
                [
                    'name' => 'Footshop',
                    'quantity' => 1,
                    'reserved' => 2,
                    'priceQuantity' => 0,
                    'priceReserved' => 0,
                ],
                [
                    'name' => 'Nike',
                    'quantity' => 1,
                    'reserved' => 2,
                    'priceQuantity' => 0,
                    'priceReserved' => 0,
                ],
                false
            );

        $pdo = $this->createMock(PDO::class);
        $pdo->expects(self::once())
            ->method('query')
            ->willReturn($pdoStatement);

        $brandStatsFactory = $this->createMock(BrandStatsFactory::class);
        $brandStatsFactory->expects(self::exactly(2))
            ->method('create')
            ->willReturnCallback(function () {
                return new BrandStats();
            });

        $repository = new PDOBrandStatsRepository($pdo, $brandStatsFactory, new BrandStatsArrayHydrator());
        $brands = $repository->findAll();

        foreach ($brands as $brand) {
            self::assertInstanceOf(BrandStats::class, $brand);
        }
    }
}
