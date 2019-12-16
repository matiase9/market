<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Config\Definition\Exception\Exception;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;


/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends EntityRepository
{
    /**
     * @param $parameters
     * @return mixed
     */
    public function save($params)
    {
        try {
            $product = New Product();
            $product->setName($params['name']);
            $product->setPrice($params['price']);
            $product->setStock($params['qty']);

            $entityManager = $this->getEntityManager();
            $entityManager->persist($product);
            $entityManager->flush();

            // Logger action
            $logger = new Logger('channel-name');
            $logger->info('SET PRODUCT => {'. $params['name'] . '}');
            $response['message'] = 'OK';
            $response['status'] = Response::HTTP_OK;
        } catch (Exception $e) {
            $logger = new Logger('connection');
            $logger->critical($e->getCode() . $e->getMessage());
        }


        return $response;
    }
}
