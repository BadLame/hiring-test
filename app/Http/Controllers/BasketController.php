<?php

namespace App\Http\Controllers;

use App\Models\Basket\ItemsBasket;
use Exception;

class BasketController extends Controller
{
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
    /** @var ItemsBasket */
    private ItemsBasket $basket;

    public function __construct(ItemsBasket $basket)
    {
        $this->basket = $basket;
    }


// ==================================================================
// ======================= Routes ===================================
    public function basket()
    {
        $items = $this->basket->getItems();

        return view("pages.basket")->with("items", $items);
    }


    public function productDetails(string $sku)
    {
        $item = $this->basket->getItem($sku) ?? @$this->mock_db[$sku];

        if (empty($item))
            return view("pages.product-details")->with("error", "Товар не найден");

        return view("pages.product-details")->with([
            "item" => $item,
            "sku" => $sku,
        ]);
    }


// ==================================================================
// ======================= Ajax area ================================
    public function addItem(string $sku, $amount = 1)
    {
        if (! is_numeric($amount) || $amount < 1)
            $amount = 1;
        // if item with this $sku not in database
        try {
            $this->basket->addItem($sku, $amount);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 404);
        }

        return response()->json([
            "message" => "In Stock",
            "amount" => $amount
        ], 200);
    }


    public function getList()
    {
        return $this->jsonHtml($this->basket->getItems());
    }

    public function changeItemAmount(string $sku, $amount)
    {
        if (!is_numeric($amount) || $amount < 1)
            $amount = 1;

        try {
            $items = $this->basket->changeAmount($sku, $amount);
        } catch (Exception $e) {
            return response()->json([
                "alert" => "Item doesn't exists"
            ], 404);
        }

        return $this->jsonHtml($items);
    }


    public function removeItem(string $sku)
    {
        $items = $this->basket->removeItem($sku);

        return $this->jsonHtml($items);
    }


    public function removeAll()
    {
        $this->basket->flush();

        return $this->jsonHtml([]);
    }


    private function jsonHtml($items)
    {
        return response()->json([
            "html" => view("components.basket-items-list")->with("items", $items)->render()
        ], 200);
    }
}
