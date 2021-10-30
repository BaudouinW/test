<?php

declare(strict_types=1);

namespace App\Tests\Unit\Services;

use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Product;
use App\Services\PriceService;
use PHPUnit\Framework\TestCase;

class PriceServiceTest extends TestCase
{
    public function testGetTotalPriceWithoutTax(): void
    {
        $product1 = new Product('Cuve à gasoil', 49600, 'Farmitoo');
        $product2 = new Product('Nettoyant pour cuve', 7500, 'Farmitoo');
        $product3 = new Product('Piquet de clôture', 500, 'Gallagher');

        $items = [
            new Item($product1, 2),
            new Item($product2, 4),
            new Item($product3, 3),
        ];

        $order = new Order($items);

        $priceService = new PriceService();

        $expected = $priceService->getTotalPriceWithoutTax($order);

        $this->assertSame(130700, $expected);
    }

    public function testGetShippingFees(): void
    {
        $product1 = new Product('Cuve à gasoil', 35600, 'Farmitoo');
        $product2 = new Product('Nettoyant pour cuve', 3000, 'Farmitoo');
        $product3 = new Product('Piquet de clôture', 352, 'Gallagher');

        $items = [
            new Item($product1, 3),
            new Item($product2, 4),
            new Item($product3, 3),
        ];

        $order = new Order($items);

        $priceService = new PriceService();

        $expected = $priceService->getShippingFees($order);

        $this->assertSame(75.0, $expected);
    }

    public function testGetTax(): void
    {
        $product1 = new Product('Cuve à gasoil', 42365, 'Farmitoo');
        $product2 = new Product('Nettoyant pour cuve', 6985, 'Farmitoo');
        $product3 = new Product('Piquet de clôture', 459, 'Gallagher');

        $items = [
            new Item($product1, 2),
            new Item($product2, 10),
            new Item($product3, 5),
        ];

        $order = new Order($items);

        $priceService = new PriceService();

        $expected = $priceService->getTax($order);

        $this->assertSame(31030.75, $expected);
    }
}
