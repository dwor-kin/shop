<?php

namespace App\Service\Cart;

use App\Service\Catalog\ProductInterface;

interface Cart
{
    public function getId(): string;
    public function getTotalPrice(): int;
    public function isFull(): bool;
    /**
     * @return ProductInterface[]
     */
    public function getProducts(): iterable;
}
