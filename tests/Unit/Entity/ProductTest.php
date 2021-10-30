<?php


namespace App\Tests\Unit\Entity;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testGetTitle(): void
    {
        $product = new Product('Cuve à gasoil', 100, 'Farmitoo');

        $this->assertSame('Cuve à gasoil', $product->getTitle());
    }

    public function testGetPrice(): void
    {
        $product = new Product('Cuve à gasoil', 350, 'Farmitoo');

        $this->assertSame(350, $product->getPrice());
    }

    public function testGetBrand(): void
    {
        $product = new Product('Piquet de clôture', 60, 'Gallagher');

        $this->assertSame('Gallagher', $product->getBrand());
    }
}
