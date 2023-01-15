<?php

namespace App\Controller\Catalog;

use App\Entity\Product;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use App\Messenger\UpdateProductInCatalog;
use App\Repository\ProductRepository;
use App\ResponseBuilder\ErrorBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products/{product}", methods={"PATCH"}, name="product-update")
 */
class UpdateController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;

    public function __construct(private readonly ErrorBuilder $errorBuilder, private readonly ProductRepository $productRepository) { }

    public function __invoke(Product $product, Request $request): Response
    {
        // TODO: przerobic na paramBuldera i dodac walidacje na pola / duplikacja kodu
        $name = trim($request->get('name'));
        $price = (int)$request->get('price');

        if ($name === '' || $price < 1) {
            return new JsonResponse(
                $this->errorBuilder->__invoke('Invalid name or price.'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $this->dispatch(new UpdateProductInCatalog($product, $name, $price));

        return new Response('', Response::HTTP_ACCEPTED);
    }
}
