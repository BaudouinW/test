<?php

declare(strict_types=1);

namespace App\Entity;

class Promotion
{
    /**
     * @param int    $minAmount
     * @param int    $reduction
     * @param bool   $freeDelivery
     * @param string $label
     */
    public function __construct(
        protected int $minAmount,
        protected int $reduction,
        protected bool $freeDelivery,
        protected string $label
    ) {}

    /**
     * @return int
     */
    public function getMinAmount(): int
    {
        return $this->minAmount;
    }

    /**
     * @return int
     */
    public function getReduction(): int
    {
        return $this->reduction;
    }

    /**
     * @return bool
     */
    public function isFreeDelivery(): bool
    {
        return $this->freeDelivery;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }
}
