<?php

namespace Flowup\ECommerce\Entity\User;
use Flowup\ECommerce\Entity\Product\Product;

/**
 * Class Seller
 *
 * Represents a seller with a store, commission rate, and the ability to manage products and stock.
 * This class extends the User class to inherit common user properties and functionality.
 */
class Seller extends User {

    /**
     * @var string The store name of the seller
     */
    private string $store;

    /**
     * @var float The commission rate of the seller (percentage)
     */
    private float $commission;

    /**
     * Seller constructor.
     *
     * Initializes a new seller object with user details, store name, and commission rate.
     *
     * @param string $name The seller's name
     * @param string $email The seller's email address
     * @param string $password The seller's password
     * @param string $store The name of the seller's store
     * @param float $commission The commission rate of the seller
     */
    public function __construct(string $name, string $email, string $password, string $store, float $commission) {
        parent::__construct($name, $email, $password);
        $this->store = $store;
        $this->commission = $commission;
    }
     /**
     * Get the customer's ID.
     *
     * @return int The customer's ID
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Set the customer's ID.
     *
     * @param int $id The customer's ID
     * @return void
     */
    public function setId(int $id): void {
        $this->id = $id;
    }


    /**
     * Get the name of the seller's store.
     *
     * @return string The seller's store name
     */
    public function getStore(): string {
        return $this->store;
    }

    /**
     * Set the name of the seller's store.
     *
     * @param string $store The new store name
     * @return void
     */
    public function setStore(string $store): void {
        $this->store = $store;
    }

    /**
     * Get the seller's commission rate.
     *
     * @return float The seller's commission rate (as a percentage)
     */
    public function getCommission(): float {
        return $this->commission;
    }

    /**
     * Set the seller's commission rate.
     *
     * @param float $commission The new commission rate (as a percentage)
     * @return void
     */
    public function setCommission(float $commission): void {
        $this->commission = $commission;
    }

    /**
     * Add a product to the seller's store.
     * This method is a placeholder for now.
     *
     * @param Product $product The product to be added to the store
     * @return void
     */
    public function addProduct(Product $product): void {
        // Method to add a product to the seller's store (empty for now)
    }

    /**
     * Manage the stock of products in the seller's store.
     * This method is a placeholder for now.
     *
     * @param Product $product The product to manage
     * @param int $quantity The quantity to adjust the stock by
     * @return void
     */
    public function manageStock(Product $product, int $quantity): void {
        // Method to manage stock of products in the store (empty for now)
    }
}
?>
