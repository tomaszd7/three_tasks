<?php
declare(strict_types=1);

namespace DealerGroup;

use DealerGroup\Exception\RemoveItemException;
use Webmozart\Assert\Assert;

class Item
{

    const MINIMAL_QUANTITY = 1;

    /**
     * @var Product
     */
    protected $product;
    /**
     * @var integer
     */
    protected $quantity;

    /**
     * Item constructor.
     *
     * @param Product $product
     * @param int     $quantity
     */
    public function __construct(Product $product, int $quantity)
    {
        Assert::greaterThanEq($quantity, self::MINIMAL_QUANTITY, "Positive quantities only.");
        $this->product = $product;
        $this->quantity = $quantity;
    }

    /**
     * @param int $quantity
     */
    public function addQuantity(int $quantity)
    {
        Assert::greaterThan($quantity, 0, "Positive quantities only.");
        $this->quantity += $quantity;
    }

    /**
     * @param int $quantity
     * @throws RemoveItemException
     */
    public function decreaseQuantity(int $quantity)
    {
        Assert::greaterThan($quantity, 0, "Positive quantities only.");
        Assert::greaterThanEq($this->quantity - $quantity, 0, "Not enough quantity to decrease.");
        $this->quantity -= $quantity;
        if ($this->quantity === 0) {
            throw new RemoveItemException();
        }
    }

    /**
     * @param  Product $productToCompare
     * @return bool
     */
    public function isSameProduct(Product $productToCompare): bool
    {
        return $this->product->getName() === $productToCompare->getName();
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->product->getPrice();
    }
}
