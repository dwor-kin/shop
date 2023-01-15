<?php

namespace App\Tests\Unit\ResponseBuilder;

use App\Entity\Product;
use App\ResponseBuilder\ProductListBuilder;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @covers ProductListBuilder
 */
class ProductListBuilderTest extends TestCase
{
    private ProductListBuilder $builder;
    private array $productsData = [
        [
            'id' => '25cc9f5d-7702-4cb0-b6fc-f93b049055ca',
            'name' => 'Product 1',
            'price' => 1200,
            'createdAt' => '2022-01-01 12:00:00',
        ],
        [
            'id' => '30e4e028-3b38-4cb9-9267-a9e515983337',
            'name' => 'Product 2',
            'price' => 1400,
            'createdAt' => '2022-01-02 12:00:00'
        ],
        [
            'id' => 'f6635017-982f-4544-9ac5-3d57107c0f0d',
            'name' => 'Product 3',
            'price' => 1500,
            'createdAt' => '2022-01-03 12:00:00'
        ],
    ];

    public function setUp(): void
    {
        parent::setUp();

        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $urlGenerator->method('generate')->willReturnCallback(
            fn(string $name, array $parameters): string => $name.json_encode($parameters, JSON_THROW_ON_ERROR)
        );

        $this->builder = new ProductListBuilder($urlGenerator);
    }

    public function test_builds_empty_product_list(): void
    {
        $this->assertEquals([
            'previous_page' => null,
            'next_page' => null,
            'count' => 0,
            'products' => [],
        ], $this->builder->__invoke([], 0, 3, 0));
    }

    public function test_builds_first_page(): void
    {
        $this->assertEquals([
            'previous_page' => null,
            'next_page' => 'product-list{"page":1}',
            'count' => 5,
            'products' => $this->getProductResponse(),
        ], $this->builder->__invoke($this->getProducts(), 0, 3, 5));
    }

    public function test_builds_last_page(): void
    {
        $this->assertEquals([
            'previous_page' => 'product-list{"page":0}',
            'next_page' => null,
            'count' => 5,
            'products' => $this->getProductResponse(),
        ], $this->builder->__invoke($this->getProducts(), 1, 3, 5));
    }

    public function test_builds_middle_page(): void
    {
        $this->assertEquals([
            'previous_page' => 'product-list{"page":0}',
            'next_page' => 'product-list{"page":2}',
            'count' => 7,
            'products' => $this->getProductResponse(),
        ], $this->builder->__invoke($this->getProducts(), 1, 3, 7));
    }

    private function getProducts(): array
    {
        $products = [];

        foreach ($this->productsData as $product) {
            $products[] = new Product(
                $product['id'],
                $product['name'],
                $product['price'],
                new DateTimeImmutable($product['createdAt']),
            );
        }

        return $products;
    }

    private function getProductResponse(): array
    {
        $products = [];

        foreach ($this->productsData as $product) {
            unset($product['createdAt']);
            $products[] = $product;
        }

        return $products;
    }
}
