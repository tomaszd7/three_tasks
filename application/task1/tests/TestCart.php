<?php
declare(strict_types=1);

namespace DealerGroup\Tests;

use DealerGroup\Cart;
use DealerGroup\Item;
use DealerGroup\Product;
use PHPUnit\Framework\TestCase;

class TestCart extends TestCase
{

    protected function prepareCartMock($expectedGetProductPosition)
    {
        $cart = $this->getMockBuilder(Cart::class)
            ->enableOriginalConstructor()
            ->setMethods(['getProductPosition'])
            ->getMock();
        $cart->method('getProductPosition')->willReturn($expectedGetProductPosition);
        return $cart;
    }

    protected function getItemsProperty()
    {
        $reflection = new \ReflectionClass(Cart::class);
        $itemsProperty = $reflection->getProperty('items');
        $itemsProperty->setAccessible(true);
        return $itemsProperty;
    }

    public function testAddProductNew()
    {
        $cart = $this->prepareCartMock(null);

        $itemsProperty = $this->getItemsProperty();

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

        $itemsProperty = $this->getItemsProperty();
        $itemsProperty->setValue($cart, [$item]);

        /** @var Cart $cart */
        $cart->addProduct($this->createMock(Product::class), 1);
    }

    // todo other tests
}
