<?php

/**
 * Class Product
 * 
 * Represents a product with properties such as ID, name, description, price, and quantity.
 * Provides methods for setting and getting product details, along with utility methods for price and stock validation.
 */
class Product {

    /**
     * @var int|null The product ID
     */
    private ?int $id;

    /**
     * @var string The product name
     */
    private string $name;

    /**
     * @var string The product description
     */
    private string $description;

    /**
     * @var float The product price (excluding tax)
     */
    private float $price;

    /**
     * @var int The available product quantity
     */
    private int $quantity;

    /**
     * Product constructor.
     * 
     * @param string $name The product name
     * @param string $description The product description
     * @param float $price The product price
     * @param int $quantity The product quantity
     */
    public function __construct(string $name, string $description, float $price, int $quantity) {
        $this->setName($name);
        $this->setDescription($description);
        $this->setPrice($price);
        $this->setQuantity($quantity);
    }

    /**
     * Gets the product ID.
     * 
     * @return int The product ID
     */
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    /**
     * Gets the product name.
     * 
     * @return string The product name
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Sets the product name.
     * 
     * @param string $name The product name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * Gets the product description.
     * 
     * @return string The product description
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * Sets the product description.
     * 
     * @param string $description The product description
     */
    public function setDescription(string $description): void {
        $this->description = $description;
    }

    /**
     * Gets the product price (excluding tax).
     * 
     * @return float The product price
     */
    public function getPrice(): float {
        return $this->price;
    }

    /**
     * Sets the product price.
     * 
     * @param float $price The product price
     * @throws InvalidArgumentException If the price is less than 0
     */
    public function setPrice(float $price): void {
        if ($price < 0) {
            throw new InvalidArgumentException("The price cannot be zero or negative.");
        }
        $this->price = $price;
    }

    /**
     * Gets the available product quantity.
     * 
     * @return int The product quantity
     */
    public function getQuantity(): int {
        return $this->quantity;
    }

    /**
     * Sets the product quantity.
     * 
     * @param int $quantity The product quantity
     * @throws InvalidArgumentException If the quantity is less than 0
     */
    public function setQuantity(int $quantity): void {
        if ($quantity < 0) {
            throw new InvalidArgumentException("Quantity cannot be less than 0.");
        }
        $this->quantity = $quantity;
    }

    /**
     * Calculates the product price including tax.
     * Assumes a 20% tax rate.
     * 
     * @return float The product price including tax
     */
    public function calculatePriceTaxInclude(): float {
        return $this->price * 1.20;
    }

    /**
     * Checks if the stock is sufficient for a given quantity.
     * 
     * @param int $quantity The quantity to check
     * @return bool True if the stock is sufficient, false otherwise
     */
    public function checkStock(): bool {
        if ($this->quantity <= 0) {
            return false;
        }
        return true;
    }
}
