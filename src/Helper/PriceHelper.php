<?php

declare(strict_types=1);

namespace App\Helper;

use App\Entity\Item;
use App\Manager\ShippingFeesManager;
use App\Manager\TaxManager;
use Symfony\Component\PropertyAccess\PropertyAccess;

class PriceHelper
{
    /**
     * @param array $items
     *
     * @return int|float
     */
    public static function calculTotalPriceWithoutTax(array $items): int|float
    {
        $totalPriceWithoutTax = 0;

        /** @var Item $item */
        foreach ($items as $item) {
            $totalPriceWithoutTax += $item->getProduct()->getPrice() * $item->getQuantity();
        }

        return $totalPriceWithoutTax;
    }

    /**
     * @param array $quantityPerBrand
     *
     * @return int|float
     */
    public static function calculShippingFeesPerBrand(array $quantityPerBrand): int|float
    {
        $shippingFees = 0;

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        foreach ($quantityPerBrand as $brand => $quantity) {
            $shippingFeesManager = new ShippingFeesManager($quantity);

            $shippingFees += $propertyAccessor->getValue($shippingFeesManager, $brand);
        }

        return $shippingFees;
    }

    /**
     * @param array $totalWithoutTaxPerBrands
     *
     * @return int|float
     */
    public static function calculTax(array $totalWithoutTaxPerBrands): int|float
    {
        $tax = 0;

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        foreach ($totalWithoutTaxPerBrands as $brand => $totalPriceWithoutTax) {
            $taxManager = new TaxManager($totalPriceWithoutTax);

            $tax += $propertyAccessor->getValue($taxManager, $brand);
        }

        return $tax;
    }
}
