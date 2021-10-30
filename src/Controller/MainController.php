<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Promotion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class MainController extends AbstractController
{
    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(protected TranslatorInterface $translator) {}

    /**
     * @Route("/", name="app_basket", methods={Request::METHOD_GET})
     *
     * @return Response
     */
    public function index(): Response
    {
        $product1 = new Product('Cuve à gasoil', 250000, 'Farmitoo');
        $product2 = new Product('Nettoyant pour cuve', 5000, 'Farmitoo');
        $product3 = new Product('Piquet de clôture', 1000, 'Gallagher');

        $promotion1 = new Promotion(
            50000,
            8,
            false,
            $this->translator->trans('promotion_text_without_free_delivery', [
                '%reduction%' => 8,
                '%minAmount%' => 50000,
            ])
        );

        // Je passe une commande avec
        // Cuve à gasoil x1
        // Nettoyant pour cuve x3
        // Piquet de clôture x5

        $items = [
            new Item($product1, 1),
            new Item($product2, 3),
            new Item($product3, 5),
        ];

        $order = new Order($items);

        return new Response($this->renderView(
            'basket/basket.html.twig',
            [
                'order'     => $order,
                'promotion' => $promotion1 ?? null,
            ]
        ));
    }
}
