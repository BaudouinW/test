<?php

declare(strict_types=1);

namespace App\Entity;

class Item
{
    /**
     * @param Product $product
     * @param int     $quantity
     */
    public function __construct(protected Product $product, protected int $quantity) {}

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
