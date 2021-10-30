<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Promotion;
use App\Helper\PriceHelper;

class PriceService
{
    /**
     * @param Order $order
     *
     * @return int|float
     */
    public function getTotalPriceWithoutTax(Order $order): int|float
    {
        $items = $order->getItems();

        return PriceHelper::calculTotalPriceWithoutTax($items);
    }

    /**
     * @param Order $order
     *
     * @return int|float
     */
    public function getShippingFees(Order $order): int|float
    {
        $quantityPerBrand = [];
        $items = $order->getItems();

        /** @var Item $item */
        foreach ($items as $item) {
            if (!array_key_exists($item->getProduct()->getBrand(), $quantityPerBrand)) {
                $quantityPerBrand[$item->getProduct()->getBrand()] = $item->getQuantity();

                continue;
            }

            $quantityPerBrand[$item->getProduct()->getBrand()] += $item->getQuantity();
        }

        return PriceHelper::calculShippingFeesPerBrand($quantityPerBrand);
    }

    /**
     * @param Order $order
     *
     * @return int|float
     */
    public function getTax(Order $order): int|float
    {
        $totalWithoutTaxPerBrands = [];
        $items = $order->getItems();

        /** @var Item $item */
        foreach ($items as $item) {
            $price = $item->getQuantity() * $item->getProduct()->getPrice();

            if (!array_key_exists($item->getProduct()->getBrand(), $totalWithoutTaxPerBrands)) {
                $totalWithoutTaxPerBrands[$item->getProduct()->getBrand()] = $price;

                continue;
            }

            $totalWithoutTaxPerBrands[$item->getProduct()->getBrand()] += $price;
        }

        return PriceHelper::calculTax($totalWithoutTaxPerBrands);
    }
}
