<?php

namespace App\Models\Basket;

use Exception;

final class SessionBasket implements ItemsBasket
{
    /** @var string Session cart key */
    private const SESSION_KEY = "session_basket";

    /** @var array Замена соединению с базой данных [ sku => data[], ... ] */
    protected array $mock_db = [
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


    public function __construct()
    {
        if (!session(self::SESSION_KEY))
            session([self::SESSION_KEY => []]);
    }


    public function addItem(string $sku, int $amount = 1): array
    {
        $items = $this->getItems();

        if (!array_key_exists($sku, $this->mock_db))
            throw new Exception("Item with SKU=$sku doesn't exists");

        $items[$sku] = $this->mock_db[$sku];
        $items[$sku]["amount"] = $amount;
        $items[$sku]["subtotal"] = (float)($items[$sku]["price"] * $amount);

        session([self::SESSION_KEY => $items]);

        return $items;
    }


    public function getItem($sku): ?array
    {
        $items = $this->getItems();

        return @$items[$sku] ?? null;
    }


    public function getItems(): array
    {
        $items = session(self::SESSION_KEY);
        return $items ?? [];
    }


    public function changeAmount(string $sku, int $amount): array
    {
        $items = $this->getItems();

        // К примеру, если товар был удалён из корзины с другой вкладки
        if (!array_key_exists($sku, $items))
            return $this->addItem($sku, $amount);

        $items[$sku]["amount"] = $amount;
        $items[$sku]["subtotal"] = $items[$sku]["price"] * $amount;
        session([self::SESSION_KEY => $items]);

        return $items;
    }


    public function removeItem(string $sku): array
    {
        $items = $this->getItems();
        unset($items[$sku]);
        session([self::SESSION_KEY => $items]);

        return $items;
    }


    public function flush(): array
    {
        $items = $this->getItems();

        session([self::SESSION_KEY => []]);

        return $items;
    }
}
