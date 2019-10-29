<?php
declare(strict_types=1);

namespace FootShop\Products\Repository\PDO;

use FootShop\Products\Factory\ProductFactory;
use FootShop\Products\Repository\ProductRepository;
use FootShop\Products\Repository\ProductsQuery;
use PDO;
use PDOStatement;

class PDOProductRepository implements ProductRepository
{
    /** @var PDO */
    private $pdo;

    /** @var ProductFactory */
    private $productFactory;

    /** @var ProductArrayHydrator */
    private $productArrayHydrator;

    public function __construct(PDO $pdo, ProductFactory $productFactory, ProductArrayHydrator $productArrayHydrator)
    {
        $this->pdo = $pdo;
        $this->productFactory = $productFactory;
        $this->productArrayHydrator = $productArrayHydrator;
    }

    public function find(ProductsQuery $query): iterable
    {
        $statement = $this->createStatement($query);
        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $product = $this->productFactory->create();
            $this->productArrayHydrator->hydrate($product, $row);

            yield $product;
        }
    }

    private function createStatement(ProductsQuery $query): PDOStatement
    {
        $where = [];
        $binds = [];

        // Product name condition
        if ($query->getName() !== null) {
            $where[] = 'p.name LIKE :name';
            $binds[] = function (PDOStatement $statement) use ($query) {
                $statement->bindValue(':name', "%{$query->getName()}%", PDO::PARAM_STR);
            };
        }

        // Brand id condition
        if ($query->getBrandId() !== null) {
            $where[] = 'b.id = :brand';
            $binds[] = function (PDOStatement $statement) use ($query) {
                $statement->bindValue(':brand', $query->getBrandId(), PDO::PARAM_INT);
            };
        }

        $where = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

        $sql = <<<SQL
SELECT p.id, p.name, p.color, p.price, p.brand_id, p.quantity, p.reserved, b.name AS brand
FROM products p
LEFT JOIN brands b ON p.brand_id = b.id
{$where}
ORDER BY :order :direction
LIMIT :limit
SQL;

        $statement = $this->pdo->prepare($sql);
        foreach ($binds as $bind) {
            $bind($statement);
        }
        $statement->bindValue(':order', $query->getOrder());
        $statement->bindValue(':direction', $query->getDirection());
        $statement->bindValue(':limit', $query->getLimit());

        return $statement;
    }
}
