<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/payment", name="app_payment", methods={Request::METHOD_GET})
     *
     * @return Response
     */
    public function payment(): Response
    {
        return new Response($this->renderView('payment/payment.html.twig'));
    }
}
