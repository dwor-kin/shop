<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private Cart $cart;

    #[ORM\ManyToOne(targetEntity: 'Product')]
    #[ORM\JoinTable(name: 'product')]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }
}
