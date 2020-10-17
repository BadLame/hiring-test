<?php

namespace App\SessionModels;

use Exception;

class SessionBasket
{
    /** @var string Session key */
    protected $basket_name;

    /** @var array Замена соединению с базой данных [ sku => data[], ... ] */
    protected $mock_db = [
        "MS04" => [
            "title" => "Dog Calcium Food",
            "price" => 20.00
        ],
        "MG25" => [
            "title" => "Dry Dog Food",
            "price" => 110.00
        ],
        "MG42" => [
            "title" => "Cat Buffalo Food",
            "price" => 150.00
        ],
        "MS03" => [
            "title" => "Legacy Dog Food",
            "price" => 170.00
        ]
    ];


    public function __construct($basket_name)
    {
        $this->basket_name = $basket_name;

        if (!session($basket_name))
            session([$basket_name => []]);
    }

    /**
     * Add item to basket
     *
     * @param string $sku
     * @param int $amount
     * @return array
     * @throws Exception
     */
    public function addItem(string $sku, int $amount = 1): array
    {
        $items = $this->getItems();

        if (!array_key_exists($sku, $this->mock_db))
            throw new Exception("Item with SKU=$sku doesn't exists");

        $items[$sku] = $this->mock_db[$sku];
        $items[$sku]["amount"] = $amount;
        $items[$sku]["subtotal"] = (float)($items[$sku]["price"] * $amount);

        session([$this->basket_name => $items]);
        session()->save();

        return $items;
    }

    /**
     * Get item if the basket containing it
     *
     * @param $sku
     * @return array|null
     */
    public function getItem($sku): ?array
    {
        $items = $this->getItems();

        return @$items[$sku] ?? null;
    }

    /**
     * Get all basket items
     *
     * @return array
     */
    public function getItems(): array
    {
        $items = session($this->basket_name);
        return $items ?? [];
    }

    /**
     * Change item amount
     *
     * @param string $sku
     * @param int $amount
     * @return array
     * @throws Exception
     */
    public function changeAmount(string $sku, int $amount): array
    {
        $items = $this->getItems();

        // К примеру, если товар был удалён из корзины с другой вкладки
        if (!array_key_exists($sku, $items))
            return $this->addItem($sku, $amount);

        $items[$sku]["amount"] = $amount;
        $items[$sku]["subtotal"] = $items[$sku]["price"] * $amount;
        session([$this->basket_name => $items]);

        return $items;
    }

    /**
     * Remove item from basket
     *
     * @param string $sku
     * @return array
     */
    public function removeItem(string $sku): array
    {
        $items = $this->getItems();
        unset($items[$sku]);
        session([$this->basket_name => $items]);

        return $items;
    }

    /**
     * Get all basket items and clear basket session array
     *
     * @return array|string[]
     */
    public function flush(): array
    {
        $items = $this->getItems();

        session([$this->basket_name => []]);

        return $items;
    }
}
