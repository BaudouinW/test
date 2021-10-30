<?php

declare(strict_types=1);

namespace App\Entity;

class Order
{
    /**
     * @param array $items
     */
    public function __construct(protected array $items) {}

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
