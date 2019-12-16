<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Config\Definition\Exception\Exception;
use App\Entity\Status;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends EntityRepository
{
    public function newOrder($product, $params)
    {
        $stockProduct = $product->getStock();

        $response = array();
        if ($stockProduct >= $params['qty']) {

            try {
                $entityManager = $this->getEntityManager();
                $priceOrder = $product->getPrice() * $params['qty'];

                $order = New Order();
                $order->setUserId($params['customer_id']);
                $order->setProductId($product->getId());
                $order->setQuantity($params['qty']);
                $order->setStatusId(Status::CODE_PEDING);
                $order->setAmount($priceOrder);
                $entityManager->persist($order);

                // Update table product
                $newQty = $stockProduct - $params['qty'];
                $product->setStock($newQty);
                $entityManager->persist($product);

                $entityManager->flush();

                // Logger action
                $logger = new Logger($params['qty']);
                $logger->info('SET ORDER => order '. $params['qty'] .' units of product. Price:'. $priceOrder);

                $response['message'] = 'The customer '. $params['customer_id']. ' buy '. $params['qty'] . ' unit: $'. $priceOrder;
                $response['status'] = Response::HTTP_OK;
            } catch (Exception $exception) {
                $logger = new Logger('connection');
                $logger->critical($exception->getCode() . $exception->getMessage());

                $response['message'] = 'Conflict to save in the database';
                $response['status'] = Response::HTTP_CONFLICT;
            }

        } else {
            $response['message'] = 'Stock not available';
            $response['status'] = Response::HTTP_CONFLICT;
        }

        return $response;
    }

}
