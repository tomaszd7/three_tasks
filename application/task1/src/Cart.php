<?php
declare(strict_types=1);

namespace DealerGroup;

use DealerGroup\Exception\ProductNotInCartException;
use DealerGroup\Exception\RemoveItemException;

class Cart
{

    /**
     * @var array|Item[]
     */
    protected $items;

    /**
     * Cart constructor.
     */
    public function __construct()
    {
        $this->items = [];
    }

    /**
     * @param Product $product
     * @param int     $quantity
     */
    public function addProduct(Product $product, int $quantity): void
    {
        if (is_null($productPosition = $this->getProductPosition($product))) {
            $this->items[] = new Item($product, $quantity);
        } else {
            $this->items[$productPosition]->addQuantity($quantity);
        }
    }


    /**
     * @param  Product $product
     * @param  int     $quantity
     * @throws \Exception
     */
    public function removeProduct(Product $product, int $quantity): void
    {
        if (is_null($productPosition = $this->getProductPosition($product))) {
            throw new ProductNotInCartException($product->getName());
        }

        try {
            $this->items[$productPosition]->decreaseQuantity($quantity);
        } catch (RemoveItemException $exception) {
            unset($this->items[$productPosition]);
        }
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        $total = 0.0;
        foreach ($this->items as $item) {
            $total += (float)($item->getQuantity() * $item->getPrice());
        }

        return round($total, Product::PRICE_ROUNDING);
    }

    /**
     * @param  Product $product
     * @return integer|null
     */
    protected function getProductPosition(Product $product): ?int
    {
        foreach ($this->items as $key => $item) {
            if ($item->isSameProduct($product)) {
                return $key;
            }
        }
        return null;
    }
}
