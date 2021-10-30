<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Order;
use App\Entity\Promotion;
use App\Services\PriceService;
use App\Services\PromotionService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PriceExtension extends AbstractExtension
{
    /**
     * @param PriceService     $priceService
     * @param PromotionService $promotionService
     */
    public function __construct(protected PriceService $priceService, protected PromotionService $promotionService) {}

    /**
     * @return TwigFunction[] array
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_total_price_without_tax', [$this, 'getTotalPriceWithoutTax']),
            new TwigFunction('get_shipping_fees', [$this, 'getShippingFees']),
            new TwigFunction('get_tax', [$this, 'getTax']),
            new TwigFunction('get_total_price_with_tax', [$this, 'getTotalPriceWithTax']),
        ];
    }

    /**
     * @param Order $order
     *
     * @return float
     */
    public function getTotalPriceWithoutTax(Order $order): float
    {
        $totalPriceWithoutTax = $this->priceService->getTotalPriceWithoutTax($order);

        return round($totalPriceWithoutTax, 2);
    }

    /**
     * @param Order          $order
     * @param Promotion|null $promotion
     *
     * @return float
     */
    public function getShippingFees(Order $order, Promotion $promotion = null): float
    {
        if (null !== $promotion && $promotion->isFreeDelivery()) {
            return 0;
        }

        $shippingFees = $this->priceService->getShippingFees($order);

        return round($shippingFees, 2);
    }

    /**
     * @param Order $order
     *
     * @return float
     */
    public function getTax(Order $order): float
    {
        $tax = $this->priceService->getTax($order);

        return round($tax, 2);
    }

    /**
     * @param Order          $order
     * @param Promotion|null $promotion
     *
     * @return float
     */
    public function getTotalPriceWithTax(Order $order, Promotion $promotion = null): float
    {
        $totalPriceWithoutTax = $this->getTotalPriceWithoutTax($order);
        $shippingFees = $this->getShippingFees($order, $promotion);
        $tax = $this->getTax($order);

        $totalPriceWithTax = $totalPriceWithoutTax + $shippingFees + $tax;

        if (null !== $promotion && 0 !== $promotion->getReduction()) {
            return $this->promotionService->getTotalPriceWithTaxWithPromotion($totalPriceWithTax, $promotion);
        }

        return round($totalPriceWithTax, 2);
    }
}
