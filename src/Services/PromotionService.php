<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Promotion;
use App\Helper\PromoHelper;
use Symfony\Contracts\Translation\TranslatorInterface;

class PromotionService
{
    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(protected TranslatorInterface $translator) {}

    /**
     * @param float     $totalPriceWithTax
     * @param Promotion $promotion
     *
     * @return float
     */
    public function getTotalPriceWithTaxWithPromotion(float $totalPriceWithTax, Promotion $promotion): float
    {
        if ($totalPriceWithTax < $promotion->getMinAmount()) {
            return $totalPriceWithTax;
        }

        return PromoHelper::calculTotalPriceWithTaxWithPromotion($totalPriceWithTax, $promotion->getReduction());
    }
}
