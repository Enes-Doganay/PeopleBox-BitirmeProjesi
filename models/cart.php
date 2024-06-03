<?php
class Cart
{
    public function addToCart($productId, $quantity)
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    }

    public function updateCart($productId, $quantity)
    {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] = $quantity;
        }
    }

    public function removeFromCart($productId)
    {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    }

    public function getCartItems()
    {
        return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }

    public function clearCart()
    {
        unset($_SESSION['cart']);
    }
}
