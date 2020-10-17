<?php

namespace App\Models\Basket;

interface ItemsBasket
{
    /**
     * Add item to cart
     *
     * @param string $id
     * @param int $amount
     * @return array
     */
    function addItem(string $id, int $amount) : array;

    /**
     * Get item from cart if exists
     *
     * @param $id
     * @return array|null
     */
    function getItem($id) : ?array;

    /**
     * Get items from cart. If none in cart - returns empty array
     *
     * @return array
     */
    function getItems() : array;

    /**
     * Change item amount
     *
     * @param string $id
     * @param int $amount
     * @return array
     */
    function changeAmount(string $id, int $amount) : array;

    /**
     * Remove item from cart
     *
     * @param string $id
     * @return array
     */
    function removeItem(string $id) : array;

    /**
     * Get all items and clean cart
     *
     * @return array
     */
    function flush() : array;
}
