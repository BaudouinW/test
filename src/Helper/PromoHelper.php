<?php

declare(strict_types=1);

namespace App\Helper;

class PromoHelper
{
    /**
     * @param float $totalPriceWithTax
     * @param float $reduction
     *
     * @return float
     */
    public static function calculTotalPriceWithTaxWithPromotion(float $totalPriceWithTax, float $reduction): float
    {
        $priceReduction = ($totalPriceWithTax * $reduction) / 100;

        return $totalPriceWithTax - $priceReduction;
    }
}
