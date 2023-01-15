<?php

namespace App\Tests\Functional\Controller\Catalog\UpdateController;

use App\Tests\Functional\WebTestCase;

class UpdateControllerTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures(new UpdateControllerFixture());
    }

    public function test_update_product(): void
    {
        $requestData = [
            'name' => 'Changed name',
            'price' => 666,
            'id' => '0d46b18e-4620-4519-8640-e62ef81b92ec'
        ];

        $this->client->request('PATCH', '/products/'.UpdateControllerFixture::PRODUCT_ID, $requestData);

        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/products');
        $response = $this->getJsonResponse();
        self::assertEquals($requestData, $response['products'][0]);
    }

    public function test_silently_ignores_product_that_does_not_exist(): void
    {
        $this->client->request('PATCH', '/products/b0263fef-82c6-49bc-81f8-a4ce7066f1d7', [
            'name' => 'Changed name',
            'price' => 666,
        ]);

        self::assertResponseStatusCodeSame(404);
    }
}
