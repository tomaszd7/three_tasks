<?php
declare(strict_types=1);

namespace DealerGroup\Tests;

use DealerGroup\Cart;
use DealerGroup\Exception\ProductNotInCartException;
use DealerGroup\Item;
use DealerGroup\Product;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class TestCart extends TestCase
{

    public function testAddProductNew()
    {
        $cart = $this->prepareCartMock(null);

        $itemsProperty = $this->getItemsPropertyReflection();

        $this->assertCount(0, $itemsProperty->getValue($cart));

        /** @var Cart $cart */
        $cart->addProduct($this->createMock(Product::class), 1);

        $this->assertCount(1, $itemsProperty->getValue($cart));
    }

    public function testAddProductExists()
    {
        $cart = $this->prepareCartMock(0);

        $item = $this->createMock(Item::class);
        $item->expects($this->once())->method('addQuantity');

        $itemsProperty = $this->getItemsPropertyReflection();
        $itemsProperty->setValue($cart, [$item]);

        /** @var Cart $cart */
        $cart->addProduct($this->createMock(Product::class), 1);
    }

    public function testRemoveProductNotInCart()
    {
        $this->expectException(ProductNotInCartException::class);

        $cart = $this->prepareCartMock(null);
        /** @var Cart $cart */
        $cart->removeProduct($this->createMock(Product::class), 1);
    }

    public function testRemoveProductInCart()
    {
        // real Cart not mock this time
        $product = new Product('test', 1);
        $cart = new Cart();
        $cart->addProduct($product, 10);

        $itemsProperty = $this->getItemsPropertyReflection();
        $this->assertEquals(10, $itemsProperty->getValue($cart)[0]->getQuantity());

        $cart->removeProduct($product, 5);
        $this->assertEquals(5, $itemsProperty->getValue($cart)[0]->getQuantity());
    }

    public function testRemoveFullyProductInCart()
    {
        // real Cart not mock this time
        $product = new Product('test', 1);
        $cart = new Cart();
        $cart->addProduct($product, 10);

        $itemsProperty = $this->getItemsPropertyReflection();
        $this->assertEquals(10, $itemsProperty->getValue($cart)[0]->getQuantity());

        $cart->removeProduct($product, 10);
        $this->assertCount(0, $itemsProperty->getValue($cart));
    }

    /**
     * @return array
     * array[0][0] price
     * array[0][1] quantity
     * array[1] result of multiplication and adding
     */
    public function getValueDataProvider()
    {
        return [
            [
                [[3.5, 1], [3.5, 1]], 7,
            ],
            [
                [[1.1, 2], [1.1, 5]], 7.7,
            ],
            // this test showed that you may override price on product so it affects same products in Cart
            // so we should change isSameProduct() in Item class to check both
            // name and price as product Identity
        ];
    }

    /**
     * @dataProvider getValueDataProvider
     * @param array $values
     * @param $result
     */
    public function testGetValue(array $values, $result)
    {
        // real Cart not mock this time
        $cart = new Cart();
        foreach ($values as $entry) {
            $cart->addProduct(new Product('name', $entry[0]), $entry[1]);
        }

        $this->assertEquals($result, $cart->getValue());
    }


    public function testGetProductPositionNotFound()
    {
        $cart = new Cart();
        $itemsProperty = $this->getItemsPropertyReflection();
        $itemsProperty->setValue($cart, [$this->getItemMock(false)]);

        $reflection = new ReflectionClass(Cart::class);
        $getProductPositionMethod = $reflection->getMethod('getProductPosition');
        $getProductPositionMethod->setAccessible(true);
        $result = $getProductPositionMethod->invokeArgs($cart, [$this->createMock(Product::class)]);
        $this->assertNull($result);
    }

    public function testGetProductPositionFound()
    {
        $cart = new Cart();
        $itemsProperty = $this->getItemsPropertyReflection();
        $itemsProperty->setValue($cart, [$this->getItemMock(true)]);

        $reflection = new ReflectionClass(Cart::class);
        $getProductPositionMethod = $reflection->getMethod('getProductPosition');
        $getProductPositionMethod->setAccessible(true);
        $result = $getProductPositionMethod->invokeArgs($cart, [$this->createMock(Product::class)]);
        $this->assertEquals(0, $result);
    }

    protected function prepareCartMock($expectedGetProductPosition)
    {
        $cart = $this->getMockBuilder(Cart::class)
            ->enableOriginalConstructor()
            ->setMethods(['getProductPosition'])
            ->getMock();
        $cart->method('getProductPosition')->willReturn($expectedGetProductPosition);
        return $cart;
    }

    protected function getItemsPropertyReflection()
    {
        $reflection = new ReflectionClass(Cart::class);
        $itemsProperty = $reflection->getProperty('items');
        $itemsProperty->setAccessible(true);
        return $itemsProperty;
    }


    protected function getItemMock($expectedIsSameProduct)
    {
        $item = $this->getMockBuilder(Item::class)
            ->disableOriginalConstructor()
            ->setMethods(['isSameProduct'])
            ->getMock();
        $item->method('isSameProduct')->willReturn($expectedIsSameProduct);
        return $item;
    }
}
