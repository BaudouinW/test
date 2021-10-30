<?php

declare(strict_types=1);

namespace App\Entity;

class Product
{
    /**
     * @param string $title
     * @param int    $price
     * @param string $brand
     */
    public function __construct(protected string $title, protected int $price, protected string $brand) {}

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }
}
