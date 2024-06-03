<?php
require_once 'models/cart.php';

class CartController
{
    private $cart;

    public function __construct()
    {
        $this->cart = new Cart();
    }

    public function addToCart($productId, $quantity)
    {
        $this->cart->addToCart($productId, $quantity);
    }

    public function updateCart($productId, $quantity)
    {
        $this->cart->updateCart($productId, $quantity);
    }

    public function removeFromCart($productId)
    {
        $this->cart->removeFromCart($productId);
    }

    public function getCartItems()
    {
        return $this->cart->getCartItems();
    }

    public function clearCart()
    {
        $this->cart->clearCart();
    }
}
