<?php
declare(strict_types=1);

namespace FootShop\Brands\Entity;

class BrandStats
{
    /** @var string */
    private $name;

    /** @var int */
    private $quantity;

    /** @var int */
    private $reserved;

    /** @var float */
    private $priceQuantity;

    /** @var float */
    private $priceReserved;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getReserved(): int
    {
        return $this->reserved;
    }

    public function setReserved(int $reserved): void
    {
        $this->reserved = $reserved;
    }

    public function getPriceQuantity(): float
    {
        return $this->priceQuantity;
    }

    public function setPriceQuantity(float $priceQuantity): void
    {
        $this->priceQuantity = $priceQuantity;
    }

    public function getPriceReserved(): float
    {
        return $this->priceReserved;
    }

    public function setPriceReserved(float $priceReserved): void
    {
        $this->priceReserved = $priceReserved;
    }
}
