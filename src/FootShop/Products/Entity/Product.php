<?php
declare(strict_types=1);

namespace FootShop\Products\Entity;

class Product
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $color;

    /** @var float */
    private $price;

    /** @var int|null */
    private $brandId;

    /** @var string|null */
    private $brandName;

    /** @var int */
    private $quantity;

    /** @var int */
    private $reserved;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getBrandId(): ?int
    {
        return $this->brandId;
    }

    public function setBrandId(?int $brandId): void
    {
        $this->brandId = $brandId;
    }

    public function getBrandName(): ?string
    {
        return $this->brandName;
    }

    public function setBrandName(?string $brandName): void
    {
        $this->brandName = $brandName;
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

    public function getSumPrice(): float
    {
        return $this->getPrice() * $this->getQuantity();
    }

    public function getSumReservedPrice(): float
    {
        return $this->getPrice() * $this->getReserved();
    }
}
