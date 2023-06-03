<?php
namespace App\Domain;

use App\Domain\CartItem;


class Cart{
	private $items;

    public function __construct(array $cartItems) {
        $this->items = $cartItems;
    }

    public function getItems() {
        return $this->items;
    }
}



