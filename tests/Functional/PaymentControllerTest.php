<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class PaymentControllerTest extends WebTestCase
{
    public const PAYMENT_URL = '/payment';

    public function testIndex(): void
    {
        $client = self::createClient();
        $client->enableProfiler();

        $client->request(Request::METHOD_GET, self::PAYMENT_URL);
        $this->assertTrue($client->getResponse()->isSuccessful());

        $crawler = $client->getCrawler();

        $this->assertSame(
            'Paiement de votre commande',
            $crawler->filter('[data-payment-title]')->text()
        );
    }
}
