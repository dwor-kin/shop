<?php

namespace App\ResponseBuilder;

use App\Service\Cart\Cart;

class CartBuilder
{
    public function __invoke(Cart $cart): array
    {
        $data = [
            'total_price' => $cart->getTotalPrice(),
            'products' => []
        ];

        var_dump($cart->getProducts());
        die();
        foreach ($cart->getProducts() as $product) {
            $data['products'][] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice()
            ];
        }

        return $data;
    }
}
