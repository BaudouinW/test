<?php

declare(strict_types=1);

namespace App\Tests\Unit\Manager;

use App\Manager\TaxManager;
use PHPUnit\Framework\TestCase;

class TaxManagerTest extends TestCase
{
    public function testGetFarmitoo(): void
    {
        $taxManager = new TaxManager(23000);

        $expected = $taxManager->getFarmitoo();

        $this->assertSame(4600.0, $expected);
    }

    public function testGetGallagher(): void
    {
        $taxManager = new TaxManager(46300);

        $expected = $taxManager->getGallagher();

        $this->assertSame(2315.0, $expected);
    }
}
