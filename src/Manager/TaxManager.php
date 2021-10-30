<?php

declare(strict_types=1);

namespace App\Manager;

class TaxManager
{
    /**
     * @param int|float $totalPriceWithoutTax
     */
    public function __construct(private int|float $totalPriceWithoutTax) {}

    /**
     * @return float
     */
    public function getFarmitoo(): float
    {
        return round($this->totalPriceWithoutTax * 0.2, 2);
    }

    /**
     * @return float
     */
    public function getGallagher(): float
    {
        return round($this->totalPriceWithoutTax * 0.05, 2);
    }
}
