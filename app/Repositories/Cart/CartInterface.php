<?php

namespace App\Repositories\Cart;

interface CartInterface
{
    public function allCartItems();
    public function addToCart($requestData);
    public function removeFromCart($id);
    public function increaseItemQty($id);
    public function decreaseItemQty($id);
}
