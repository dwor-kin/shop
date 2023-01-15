<?php

namespace App\DataFixtures;

use App\Entity\Cart;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DataFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            new Product(
                '25cc9f5d-7702-4cb0-b6fc-f93b049055ca',
                'Product 1',
                1200,
                new \DateTimeImmutable('2022-01-01 12:00:00'),
            ),
            new Product(
                '30e4e028-3b38-4cb9-9267-a9e515983337',
                'Product 2',
                1400,
                new \DateTimeImmutable('2022-01-02 12:00:00')
            ),
            new Product(
                'f6635017-982f-4544-9ac5-3d57107c0f0d',
                'Product 3',
                1500,
                new \DateTimeImmutable('2022-01-03 12:00:00'),
            ),
            new Product(
                'f6635017-982f-4544-9ac5-3d57107c0666',
                'Product 4',
                1600,
                new \DateTimeImmutable('2022-01-04 12:00:00'),
            ),
            new Product(
                'f6635017-982f-4544-9ac5-3d57107c0667',
                'Product 5',
                1700,
                new \DateTimeImmutable('2022-01-05 12:00:00'),
            ),
            new Product(
                'f6635017-982f-4544-9ac5-3d57107c0668',
                'Product 6',
                9999,
                new \DateTimeImmutable('2022-01-06 12:00:00'),
            ),
            new Product(
                'f6635017-982f-4544-9ac5-3d57107c0342',
                'Product 7',
                7777,
                new \DateTimeImmutable('2022-01-07 12:00:00'),
            ),
        ];

        foreach ($products as $product) {
            $manager->persist($product);
        }

        $fullCart = new Cart('1e82de36-23f3-4ae7-ad5d-616295f1d6c0');
        $fullCart->addProduct($products[0]);
        $fullCart->addProduct($products[1]);
//        $fullCart->addProduct($products[2]);
//        $fullCart->addProduct($products[3]);
//        $fullCart->addProduct($products[4]);

        $manager->persist($fullCart);

//        $fullCart = new Cart('1e82de36-23f3-4ae7-ad5d-666295f1d6c0');
//        $fullCart->addProduct($products[5]);
//        $fullCart->addProduct($products[6]);
//        $manager->persist($fullCart);

        $manager->flush();
    }
}
