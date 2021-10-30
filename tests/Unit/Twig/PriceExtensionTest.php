<?php

declare(strict_types=1);

namespace App\Tests\Unit\Twig;

use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Services\PriceService;
use App\Services\PromotionService;
use App\Twig\PriceExtension;
use PHPUnit\Framework\TestCase;

class PriceExtensionTest extends TestCase
{
    public function testGetTotalPriceWithTax(): void
    {
        $product1 = new Product('Cuve à gasoil', 36498, 'Farmitoo');
        $product2 = new Product('Nettoyant pour cuve', 6415, 'Farmitoo');
        $product3 = new Product('Piquet de clôture', 635, 'Gallagher');

        $items = [
            new Item($product1, 6),
            new Item($product2, 2),
            new Item($product3, 10),
        ];

        $order = new Order($items);

        $priceService = $this->createMock(PriceService::class);
        $promotionService = $this->getMockBuilder(PromotionService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getTotalPriceWithTaxWithPromotion'])
            ->getMock();

        $priceExtension = $this->getMockBuilder(PriceExtension::class)
            ->setConstructorArgs([$priceService, $promotionService])
            ->onlyMethods([
                'getTotalPriceWithoutTax',
                'getShippingFees',
                'getTax'
            ])
            ->getMock();

        $priceExtension->expects($this->exactly(2))
            ->method('getTotalPriceWithoutTax')
            ->willReturn(238168.0);

        $priceExtension->expects($this->exactly(2))
            ->method('getShippingFees')
            ->willReturn(75.0);

        $priceExtension->expects($this->exactly(2))
            ->method('getTax')
            ->willReturn(46363.6);

        $expectedWithoutPromotion = $priceExtension->getTotalPriceWithTax($order);

        $this->assertSame(284606.6, $expectedWithoutPromotion);

        $promotion = new Promotion(
            65000,
            7,
            false,
            'Test promotion'
        );

        $promotionService->expects($this->exactly(1))
            ->method('getTotalPriceWithTaxWithPromotion')
            ->willReturn(264684.13);

        $expectedWithPromotion = $priceExtension->getTotalPriceWithTax($order, $promotion);

        $this->assertSame(264684.13, $expectedWithPromotion);
    }

    public function testGetShippingFeesWithFreeDelivery(): void
    {
        $product1 = new Product('Cuve à gasoil', 36498, 'Farmitoo');
        $product2 = new Product('Nettoyant pour cuve', 6415, 'Farmitoo');
        $product3 = new Product('Piquet de clôture', 635, 'Gallagher');

        $items = [
            new Item($product1, 6),
            new Item($product2, 2),
            new Item($product3, 10),
        ];

        $order = new Order($items);

        $promotion = new Promotion(36420, 5, true, 'Test promotion');

        $priceService = $this->createMock(PriceService::class);
        $promotionService = $this->createMock(PromotionService::class);

        $priceExtension = new PriceExtension($priceService, $promotionService);

        $expected = $priceExtension->getShippingFees($order, $promotion);

        $this->assertSame(0.0, $expected);
    }
}
