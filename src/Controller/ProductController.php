<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PhpParser\Node\Scalar\MagicConst\Dir;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\Container;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;

/**
 * Product controller.
 * @Route("/api", name="api_")
 */
class ProductController extends AbstractFOSRestController
{
    // These messages must be created in another class for better organization.
    const PRODUCT_NOT_FOUND = 'Product not found';

    /**
     * Get all Product.
     * @Get("/product/{id}", name="product")
     *
     * @return Response
     */
    public function getProductAction($id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        if (!empty($product)) {
            return $this->view($product, Response::HTTP_OK);
        }

        return $this->view(self::PRODUCT_NOT_FOUND, Response::HTTP_FOUND);
    }

    /**
     * Create new Product.
     * @Put("/product/new", name="product_new")
     *
     * @return Response
     */
    public function putNewAction(Request $request)
    {
        $nameRequest = $request->get('name');
        $priceRequest = $request->get('price');
        $quantityRequest = $request->get('stock');

        if (!$nameRequest | !$priceRequest | !$quantityRequest) {
            return $this->view('Check the parameters required.', Response::HTTP_FORBIDDEN);
        }

        $parameters = array (
            'name' => $nameRequest,
            'price' => $priceRequest,
            'qty' => $quantityRequest
        );

        $response = $this->getDoctrine()->getRepository(Product::class)->save($parameters);

        return $this->view($response['message'], $response['status']);
    }

    /**
     * Remove Product.
     * @Delete("/product/delete/{id}", name="product_remove")
     * @return Response
     */
    public function deleteProductAction($id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        if (!empty($product)) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();

            return $this->view('Product removed', Response::HTTP_OK);
        }

        return $this->view(self::PRODUCT_NOT_FOUND, Response::HTTP_FOUND);
    }



}