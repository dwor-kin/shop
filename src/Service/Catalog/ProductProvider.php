<?php

namespace App\Service\Catalog;

use App\Entity\Product;

interface ProductProvider
{
    /**
     * @return Product[]
     */
    public function getProducts(int $page = 0, int $count = 3): iterable;

    public function exists(string $productId): bool;

    public function getTotalCount(): int;
}
