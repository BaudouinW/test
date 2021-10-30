<?php

declare(strict_types=1);

namespace App\Manager;

class ShippingFeesManager
{
    /**
     * @param int $quantity
     */
    public function __construct(private int $quantity) {}

    /**
     * @return float
     */
    public function getFarmitoo(): float
    {
        return ceil($this->quantity / 3) * 20;
    }

    /**
     * @return int
     */
    public function getGallagher(): int
    {
        return 15;
    }
}
