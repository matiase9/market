<?php

namespace App\Tests;

use App\Controller\ProductController;
use App\Entity\Product;
use Symfony\Component\HttpKernel\HttpKernelBrowser;
use Symfony\Component\HttpFoundation\Request;
use PHPUnit\Framework\TestCase;

use Symfony\Component\HttpClient\HttpClient;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductTest extends  WebTestCase
{


    public function testgetProductName()
    {
        $product = new \App\Entity\Product;

        $product->setName('Test');

        $this->assertEquals($product->getName(), 'Test');
    }

    public function testgetProductPrice()
    {
        $product = new \App\Entity\Product;

        $product->setPrice('1.0');

        $this->assertEquals($product->getPrice(), '1.0');
    }

    public function testgetProductStock()
    {
        $product = new \App\Entity\Product;

        $product->setStock('100');

        $this->assertEquals($product->getStock(), '100');
    }


    public function testgetProduct()
    {

        $client = static::createClient();

        $client->request('GET', '/product/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }
}