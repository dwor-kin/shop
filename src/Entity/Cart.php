<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Cart implements \App\Service\Cart\Cart
{
    public const CAPACITY = 3;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', nullable: false)]
    private UuidInterface $id;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: CartProducts::class, cascade: ["persist"])]
    private Collection $products;

    public function __construct(string $id)
    {
        $this->id = Uuid::fromString($id);
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getTotalPrice(): int
    {
        return array_reduce(
            $this->products->toArray(),
            static fn(int $total, Product $product): int => $total + $product->getPrice(),
            0
        );
    }

    #[Pure]
    public function isFull(): bool
    {
        return $this->products->count() >= self::CAPACITY;
    }

    public function getProducts(): iterable
    {
        return $this->products->getIterator();
    }

    #[Pure]
    public function hasProduct(\App\Entity\Product $product): bool
    {
        return $this->products->contains($product);
    }

    public function addProduct(\App\Entity\Product $product): void
    {
        $this->products->add($product);
    }

    public function removeProduct(\App\Entity\Product $product): void
    {
        $this->products->removeElement($product);
    }
}
