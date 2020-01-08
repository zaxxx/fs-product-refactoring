<?php
declare(strict_types=1);

namespace FootShop\Products\Query;

use InvalidArgumentException;

class ProductsQuery
{
    private const DIRECTION_ASC = 'ASC';
    private const DIRECTION_DESC = 'DESC';

    private const DEFAULT_ORDER = 'id';
    private const DEFAULT_DIRECTION = self::DIRECTION_ASC;
    private const DEFAULT_LIMIT = 10;

    /** @var string|null */
    private $name;

    /** @var int|null */
    private $brandId;

    /** @var string */
    private $order = self::DEFAULT_ORDER;

    /** @var string */
    private $direction = self::DEFAULT_DIRECTION;

    /** @var int */
    private $limit = self::DEFAULT_LIMIT;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getBrandId(): ?int
    {
        return $this->brandId;
    }

    public function setBrandId(?int $brandId): void
    {
        $this->brandId = $brandId;
    }

    public function getOrder(): string
    {
        return $this->order;
    }

    public function setOrder(string $order): void
    {
        $this->order = $order;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     * @throws InvalidArgumentException
     */
    public function setDirection(string $direction): void
    {
        if (!in_array($direction, [self::DIRECTION_ASC, self::DIRECTION_DESC], true)) {
            throw new InvalidArgumentException(sprintf('Invalid direction %s - expected ASC or DESC.', $direction));
        }
        $this->direction = $direction;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }
}
