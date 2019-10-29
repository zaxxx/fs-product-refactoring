<?php
declare(strict_types=1);

namespace Tests\Unit\FootShop\Products\Repository\PDO;

use FootShop\Products\Entity\Product;
use FootShop\Products\Factory\ProductFactory;
use FootShop\Products\Repository\PDO\PDOProductRepository;
use FootShop\Products\Repository\PDO\ProductArrayHydrator;
use FootShop\Products\Query\ProductsQuery;
use PDO;
use PDOStatement;
use PHPUnit\Framework\MockObject\Stub\ReturnCallback;
use PHPUnit\Framework\TestCase;

class PDOProductRepositoryTest extends TestCase
{
    public function testFindSimple(): void
    {
        $pdoStatement = $this->createMock(PDOStatement::class);
        $pdoStatement->expects(self::exactly(3))
            ->method('fetch')
            ->willReturnOnConsecutiveCalls(
                [
                    'id' => 2,
                    'name' => 'Nike Sportswear Table Tee',
                    'color' => 'Black/ University Red',
                    'price' => 790,
                    'brand_id' => 2,
                    'brand' => 'Nike',
                    'quantity' => 10,
                    'reserved' => 1,
                ],
                [
                    'id' => 3,
                    'name' => 'The North Face M Shortsleeve Fine 2 Tee',
                    'color' => 'Tillandsia Purple',
                    'price' => 890,
                    'brand_id' => 3,
                    'brand' => 'The North Face',
                    'quantity' => 20,
                    'reserved' => 15,
                ],
                false
            );
        $pdoStatement->expects(self::exactly(3))
            ->method('bindValue')
            ->willReturnOnConsecutiveCalls(
                new ReturnCallback(function ($parameter, $value) {
                    self::assertEquals(':order', $parameter);
                    self::assertEquals('id', $value);
                }),
                new ReturnCallback(function ($parameter, $value) {
                    self::assertEquals(':direction', $parameter);
                    self::assertEquals('ASC', $value);
                }),
                new ReturnCallback(function ($parameter, $value) {
                    self::assertEquals(':limit', $parameter);
                    self::assertEquals(10, $value);
                })
            );

        $pdo = $this->createMock(PDO::class);
        $pdo->expects(self::once())
            ->method('prepare')
            ->willReturnCallback(function (string $sql) use ($pdoStatement) {
                $expectedSql = <<<SQL
SELECT p.id, p.name, p.color, p.price, p.brand_id, p.quantity, p.reserved, b.name AS brand
FROM products p
LEFT JOIN brands b ON p.brand_id = b.id

ORDER BY :order :direction
LIMIT :limit
SQL;

                self::assertEquals($expectedSql, $sql);

                return $pdoStatement;
            });

        $productFactory = $this->createMock(ProductFactory::class);
        $productFactory->expects(self::exactly(2))
            ->method('create')
            ->willReturnCallback(function () {
                return new Product();
            });
        $repository = new PDOProductRepository($pdo, $productFactory, new ProductArrayHydrator());
        $products = $repository->find(new ProductsQuery());
        foreach ($products as $product) {
            self::assertInstanceOf(Product::class, $product);
        }
    }

    public function testFindWithConditions(): void
    {
        $pdoStatement = $this->createMock(PDOStatement::class);
        $pdoStatement->expects(self::exactly(3))
            ->method('fetch')
            ->willReturnOnConsecutiveCalls(
                [
                    'id' => 2,
                    'name' => 'Nike Sportswear Table Tee',
                    'color' => 'Black/ University Red',
                    'price' => 790,
                    'brand_id' => 2,
                    'brand' => 'Nike',
                    'quantity' => 10,
                    'reserved' => 1,
                ],
                [
                    'id' => 3,
                    'name' => 'The North Face M Shortsleeve Fine 2 Tee',
                    'color' => 'Tillandsia Purple',
                    'price' => 890,
                    'brand_id' => 3,
                    'brand' => 'The North Face',
                    'quantity' => 20,
                    'reserved' => 15,
                ],
                false
            );
        $pdoStatement->expects(self::exactly(5))
            ->method('bindValue')
            ->willReturnOnConsecutiveCalls(
                new ReturnCallback(function ($parameter, $value) {
                    self::assertEquals(':name', $parameter);
                    self::assertEquals('%abc%', $value);
                }),
                new ReturnCallback(function ($parameter, $value) {
                    self::assertEquals(':brand', $parameter);
                    self::assertEquals(2, $value);
                }),
                new ReturnCallback(function ($parameter, $value) {
                    self::assertEquals(':order', $parameter);
                    self::assertEquals('id', $value);
                }),
                new ReturnCallback(function ($parameter, $value) {
                    self::assertEquals(':direction', $parameter);
                    self::assertEquals('ASC', $value);
                }),
                new ReturnCallback(function ($parameter, $value) {
                    self::assertEquals(':limit', $parameter);
                    self::assertEquals(10, $value);
                })
            );

        $pdo = $this->createMock(PDO::class);
        $pdo->expects(self::once())
            ->method('prepare')
            ->willReturnCallback(function (string $sql) use ($pdoStatement) {
                $expectedSql = <<<SQL
SELECT p.id, p.name, p.color, p.price, p.brand_id, p.quantity, p.reserved, b.name AS brand
FROM products p
LEFT JOIN brands b ON p.brand_id = b.id
WHERE p.name LIKE :name AND b.id = :brand
ORDER BY :order :direction
LIMIT :limit
SQL;

                self::assertEquals($expectedSql, $sql);

                return $pdoStatement;
            });

        $productFactory = $this->createMock(ProductFactory::class);
        $productFactory->expects(self::exactly(2))
            ->method('create')
            ->willReturnCallback(function () {
                return new Product();
            });

        $query = new ProductsQuery();
        $query->setBrandId(2);
        $query->setName('abc');

        $repository = new PDOProductRepository($pdo, $productFactory, new ProductArrayHydrator());
        $products = $repository->find($query);
        foreach ($products as $product) {
            self::assertInstanceOf(Product::class, $product);
        }
    }
}
