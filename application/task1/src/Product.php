<?php
declare(strict_types=1);

namespace DealerGroup;

class Product
{

    const PRICE_ROUNDING = 2;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var float
     */
    protected $price;

    /**
     * Product constructor.
     *
     * @param string $name
     * @param float  $price
     */
    public function __construct(string $name, float $price)
    {
        $this->name = $name;
        $this->price = round($price, self::PRICE_ROUNDING);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
