<?php
declare(strict_types=1);

namespace DealerGroup\Exception;

use Throwable;

class ProductNotInCartException extends \Exception
{

    protected $message = "Product is not in the cart: %s";

    /**
     * RemoveItemException constructor.
     * @param string $productName
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $productName, $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf($this->message, $productName), $code, $previous);
    }
}
