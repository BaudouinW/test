<?php

declare(strict_types=1);

namespace App\Tests\Unit\Manager;

use App\Manager\ShippingFeesManager;
use PHPUnit\Framework\TestCase;

class ShippingFeesManagerTest extends TestCase
{
    public function testGetFarmitoo(): void
    {
        $shippingFeesManager = new ShippingFeesManager(7);

        $expected = $shippingFeesManager->getFarmitoo();

        $this->assertSame(60.0, $expected);
    }
}
