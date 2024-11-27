<?php

namespace Flowup\ECommerce\Entity;
use DateTime;
use Flowup\ECommerce\Entity\Product\Product;


class Cart {

    /**
     * @var array Associative array where the key is the product ID and the value is an array containing the product and its quantity
     */
    private array $articles = [];

    /**
     * @var DateTime The date when the cart was created
     */
    private DateTime $dateCreation;

    /**
     * Cart constructor.
     */
    public function __construct() {
        $this->dateCreation = new DateTime();
    }

    /**
     * Adds a product to the cart with a specified quantity. If the product already exists, it increases the quantity.
     * 
     * @param Product $product The product to add to the cart
     * @param int $quantity The quantity of the product
     */
    public function addProduct(Product $product, int $quantity): void {
        $productId = $product->getId();
        
        // Check if product already exists in the cart
        if (isset($this->articles[$productId])) {
            $this->articles[$productId]['quantity'] += $quantity;
        } else {
            $this->articles[$productId] = ['product' => $product, 'quantity' => $quantity];
        }
    }

    /**
     * Removes a specified quantity of a product from the cart. Removes the product completely if quantity reaches zero or below.
     * 
     * @param Product $product The product to remove
     * @param int $quantity The quantity to remove
     */
    public function removeProduct(Product $product, int $quantity): void {
        $productId = $product->getId();

        // Check if the product exists in the cart
        if (isset($this->articles[$productId])) {
            $this->articles[$productId]['quantity'] -= $quantity;

            // If quantity drops to zero or below, remove the product from the cart
            if ($this->articles[$productId]['quantity'] <= 0) {
                unset($this->articles[$productId]);
            }
        }
    }

    /**
     * Empties the cart by removing all products and their quantities.
     */
    public function clear(): void {
        $this->articles = [];
    }

    /**
     * Calculates and returns the total cart value including VAT for each product.
     * 
     * @return float The total price of all products in the cart
     */
    public function calculateTotal(): float {
        $total = 0.0;

        foreach ($this->articles as $item) {
            $product = $item['product'];
            $quantity = $item['quantity'];
            $total += $product->calculatePriceTaxInclude() * $quantity;
        }

        return $total;
    }

    /**
     * Returns the total number of items in the cart.
     * 
     * @return int The total number of items in the cart
     */
    public function countItems(): int {
        $totalItems = 0;

        foreach ($this->articles as $item) {
            $totalItems += $item['quantity'];
        }

        return $totalItems;
    }

    // Getters and Setters

    /**
     * get creation date of the init cart
     *
     * @return DateTime
     */
    public function getDateCreation(): DateTime {
        return $this->dateCreation;
    }

    /**
     * set Date Creation at the creation of a cart
     *
     * @param DateTime $dateCreation
     * @return void
     */
    public function setDateCreation(DateTime $dateCreation): void {
        $this->dateCreation = $dateCreation;
    }

    /**
     * Returns the list of articles (products with their quantities) in the cart.
     * 
     * @return array The array of articles in the cart
     */
    public function getArticles(): array {
        return $this->articles;
    }
}
?>
