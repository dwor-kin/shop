<?php

namespace App\Service\Catalog;

interface Product
{
    public function getId(): string;
    public function getName(): string;
    public function getPrice(): int;
    public function setName(string $name): void;
    public function setPrice(int $price): void;
}
