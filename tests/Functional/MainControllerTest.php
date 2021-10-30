<?php


namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class MainControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = self::createClient();
        $client->enableProfiler();

        $client->request(Request::METHOD_GET, '/');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $crawler = $client ->getCrawler();

        $this->assertSame('Mon panier', $crawler->filter('[data-basket-title]')->text());
        $this->assertCount(3, $crawler->filter('[data-item-informations]'));

        $secondLine = $crawler->filter('[data-item-informations]')->eq(1);
        $this->assertSame('Nettoyant pour cuve', $secondLine->filter('[data-item-title]')->text());
        $this->assertSame('Farmitoo', $secondLine->filter('[data-item-brand]')->text());
        $this->assertSame('3', $secondLine->filter('[data-item-quantity]')->text());
        $this->assertSame('5000 €', $secondLine->filter('[data-item-price]')->text());

        $totalElements = $crawler->filter('[data-total]');
        $this->assertSame('270000 €', $totalElements->filter('[data-total-without-tax]')->text());
        $this->assertSame('55 €', $totalElements->filter('[data-shipping-fees]')->text());
        $this->assertSame('53250 €', $totalElements->filter('[data-tax]')->text());
        $this->assertSame('297440.6 €', $totalElements->filter('[data-total-with-tax]')->text());
    }
}
