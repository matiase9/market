<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Order;
use App\Entity\User;
use App\Repository\OrderRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Post;

/**
 * Order controller.
 * @Route("/api", name="api_")
 */
class OrderController extends AbstractFOSRestController
{
    /**
     * New Order.
     * @Post("/order/new", name="order_new")
     *
     * @return Response
     */
    public function postNewAction(Request $request)
    {
        $customerIdRequest = $request->get('user_id');
        $productIdRequest = $request->get('product_id');
        $qtyRequest = $request->get('quantity');

        if (!$productIdRequest | !$qtyRequest | !$customerIdRequest) {
            return $this->view('Check the parameters required.', Response::HTTP_FORBIDDEN);
        }


        $product = $this->getDoctrine()->getRepository(Product::class)->find($productIdRequest);

        if (!empty($product)) {
            $params = array (
                'user_id' => $customerIdRequest,
                'product_id' => $productIdRequest,
                'qty' => $qtyRequest
            );
            $response = $this->getDoctrine()->getRepository(Order::class)->newOrder($params);

            if ($response['message']) {
                return $this->view($response['message'], $response['status']);
            } else {
                return $this->view('Not found', Response::HTTP_FOUND);
            }

        } else {
            return $this->view('Product not found', Response::HTTP_FOUND);
        }
    }
}
