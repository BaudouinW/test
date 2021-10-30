<?php

declare(strict_types=1);

namespace App\Tests\Unit\Services;

use App\Entity\Promotion;
use App\Services\PromotionService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;

class PromoServiceTest extends TestCase
{
    public function testGetTotalPriceWithTaxWithPromotion(): void
    {
        $promotion = new Promotion(
            35000,
            10,
            false,
            'Test promotion'
        );

        $translatorMock = $this->createMock(TranslatorInterface::class);

        $promotionService = new PromotionService($translatorMock);

        $expectedWithMinAmountCondition = $promotionService->getTotalPriceWithTaxWithPromotion(
            60000,
            $promotion
        );

        $this->assertSame(54000.0, $expectedWithMinAmountCondition);

        $expectedWithoutMinAmountCondition = $promotionService->getTotalPriceWithTaxWithPromotion(
            30000,
            $promotion
        );

        $this->assertSame(30000.0, $expectedWithoutMinAmountCondition);
    }
}
