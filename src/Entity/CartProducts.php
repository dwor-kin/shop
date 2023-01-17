<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class CartProducts
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    public readonly int $id;

    #[ORM\ManyToOne(targetEntity: Cart::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: 'cart_uuid', referencedColumnName: 'id')]
    private Cart $cart;

    #[ORM\ManyToOne(targetEntity: Product::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: 'product_uuid', referencedColumnName: 'id')]
    private Product $product;

    public function __construct(Cart $cart, Product $product)
    {
        $this->cart = $cart;
        $this->product = $product;
    }
}
