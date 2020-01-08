<?php
declare(strict_types=1);

namespace Tests\Unit\FootShop\Brands\Repository\PDO;

use FootShop\Brands\Entity\Brand;
use FootShop\Brands\Factory\BrandFactory;
use FootShop\Brands\Repository\PDO\BrandArrayHydrator;
use FootShop\Brands\Repository\PDO\PDOBrandRepository;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class PDOBrandRepositoryTest extends TestCase
{
    public function testFindAll(): void
    {
        $pdoStatement = $this->createMock(PDOStatement::class);
        $pdoStatement->expects(self::exactly(3))
            ->method('fetch')
            ->willReturnOnConsecutiveCalls(
                [
                    'id' => 1,
                    'name' => 'Footshop',
                ],
                [
                    'id' => 2,
                    'name' => 'Nike',
                ],
                false
            );

        $pdo = $this->createMock(PDO::class);
        $pdo->expects(self::once())
            ->method('query')
            ->willReturn($pdoStatement);

        $brandFactory = $this->createMock(BrandFactory::class);
        $brandFactory->expects(self::exactly(2))
            ->method('create')
            ->willReturnCallback(function () {
                return new Brand();
            });

        $repository = new PDOBrandRepository($pdo, $brandFactory, new BrandArrayHydrator());
        $brands = $repository->findAll();

        foreach ($brands as $brand) {
            self::assertInstanceOf(Brand::class, $brand);
        }
    }
}
