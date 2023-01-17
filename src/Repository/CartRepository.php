<?php

namespace App\Repository;

use App\Entity\Product;
use App\Service\Cart\Cart;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class CartRepository implements CartService
{
    public function __construct(private readonly EntityManagerInterface $entityManager) {}

    public function addProduct(string $cartId, string $productId): void
    {
        $cart = $this->entityManager->find(Cart::class, $cartId);

        $product = $this->entityManager->find(Product::class, $productId);

        // TODO: to i tak nie dziala :( straciłem już cierpliwość do tego
        if ($cart && $product && !$cart->hasProduct($product)) {
            $cart->addProduct($product);
            $this->entityManager->persist($cart);

//            $newProd = new Product('7777f5d-7702-4cb0-b6fc-f93b049055ca', 'test', 1200);
//            $this->entityManager->persist($newProd);

            $this->entityManager->flush();
        }
    }

    public function removeProduct(string $cartId, string $productId): void
    {
        $cart = $this->entityManager->find(\App\Entity\Cart::class, $cartId);
        $product = $this->entityManager->find(Product::class, $productId);

        if ($cart && $product && $cart->hasProduct($product)) {
            $cart->removeProduct($product);
            $this->entityManager->persist($cart);
            $this->entityManager->flush();
        }
    }

    public function create(): Cart
    {
        $cart = new \App\Entity\Cart(Uuid::uuid4()->toString());

        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        return $cart;
    }
}
