<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);

use DealerGroup\Cart;
use DealerGroup\Product;

require 'vendor/autoload.php';

$product1 = new Product('product_1', 0.7);
$product2 = new Product('product_2', 9.3);

$cart = new Cart();
$cart->addProduct($product1, 5);
$cart->addProduct($product2,5);
$cart->removeProduct($product2, 5);


var_dump($cart->getValue());