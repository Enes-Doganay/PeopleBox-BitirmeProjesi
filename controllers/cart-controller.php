<?php
require_once 'models/cart.php';
require_once 'controllers/book-controller.php';

class CartController
{
    private $cart;
    private $bookController;

    public function __construct()
    {
        $this->cart = new Cart();
        $this->bookController = new BookController();
    }

    public function addToCart($productId, $quantity)
    {
        $this->cart->addToCart($productId, $quantity);
    }

    public function updateCart($productId, $quantity)
    {
        $book = $this->bookController->getById($productId);

        if ($book["stock"] >= $quantity) {
            $this->cart->updateCart($productId, $quantity);
        } else {
            throw new Exception("Yeterli stok yok!");
        }
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
