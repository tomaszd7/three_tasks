<?php
declare(strict_types=1);

namespace DealerGroup\Tests;

use DealerGroup\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{

    public function constructDataProvider()
    {
        return [
            ['test', 1],
            ['test', 45.45]
        ];
    }

    /**
     * @dataProvider constructDataProvider
     * @param $name
     * @param $price
     */
    public function testConstruct($name, $price)
    {
        $product = new Product($name, $price);
        $this->assertEquals($name, $product->getName());
        $this->assertEquals($price, $product->getPrice());
    }

    public function testGetName()
    {
        $name = 'Somename';
        $product = new Product($name, 0);
        $this->assertEquals($name, $product->getName(), "Name is not equal.");
    }

    public function getPriceDataProvider()
    {
        return [
            [0, 0],
            [6, 6.0],
            [1.1, 1.1],
            [30.4678, 30.47],
        ];
    }

    /**
     * @dataProvider getPriceDataProvider
     * @param $price
     * @param $result
     */
    public function testGetPrice($price, $result)
    {
        $product = new Product('test', $price);
        $this->assertEquals($result, $product->getPrice());
    }
}
