<?php


namespace DealerGroup\Tests;

use DealerGroup\Exception\RemoveItemException;
use DealerGroup\Item;
use DealerGroup\Product;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{

    protected function getMockedProduct()
    {
        return $this->createMock(Product::class);
    }

    public function testConstructFailure()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Item($this->getMockedProduct(), 0);
    }

    public function testAddQuantityFailure()
    {
        $item = new Item($this->getMockedProduct(), 1);
        $this->expectException(\InvalidArgumentException::class);
        $item->addQuantity(0);
    }

    public function testAddQuantity()
    {
        $item = new Item($this->getMockedProduct(), 1);
        $item->addQuantity(10);
        $this->assertEquals(11, $item->getQuantity());
    }

    public function decreaseQuantityFailureDataProvider()
    {
        return [
            [0],
            [10],
        ];
    }

    /**
     * @dataProvider decreaseQuantityFailureDataProvider
     * @param $quantity
     * @throws RemoveItemException
     */
    public function testDecreaseQuantityFailure($quantity)
    {
        $item = new Item($this->getMockedProduct(), 1);
        $this->expectException(\InvalidArgumentException::class);
        $item->decreaseQuantity($quantity);
    }

    public function testDecreaseQuantity()
    {
        $item = new Item($this->getMockedProduct(), 10);
        $item->decreaseQuantity(5);
        $this->assertEquals(5, $item->getQuantity());
    }


    public function testDecreaseQuantityRemoveItem()
    {
        $this->expectException(RemoveItemException::class);
        $item = new Item($this->getMockedProduct(), 1);
        $item->decreaseQuantity(1);
    }


    public function testIsSameProductTrue()
    {
        $productA = $this->getMockedProduct();
        $productA->method('getName')->willReturn('A');

        $productB = $this->getMockedProduct();
        $productB->method('getName')->willReturn('A');

        $item = new Item($productA, 1);
        $this->assertTrue($item->isSameProduct($productB));
    }


    public function testIsSameProductFalse()
    {
        $productA = $this->getMockedProduct();
        $productA->method('getName')->willReturn('A');

        $productB = $this->getMockedProduct();
        $productB->method('getName')->willReturn('B');

        $item = new Item($productA, 1);
        $this->assertFalse($item->isSameProduct($productB));
    }

    public function testGetQuantity()
    {
        $quantity = 10;
        $item = new Item($this->getMockedProduct(), $quantity);
        $this->assertEquals($quantity, $item->getQuantity());
    }


    public function testGetPrice()
    {
        $price = 2.34;
        $product = $this->getMockedProduct();
        $product->method('getPrice')->willReturn($price);

        $item = new Item($product, 1);
        $this->assertEquals($price, $item->getPrice());
    }
}
