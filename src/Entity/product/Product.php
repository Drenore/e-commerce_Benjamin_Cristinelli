<?php 

namespace Flowup\ECommerce\Entity\Product;

use Flowup\ECommerce\Config\ConfigurationManager;

/**
 * Class Product
 * 
 * Represents a product with properties such as ID, name, description, price, and quantity.
 * Defines abstract methods to be implemented by subclasses.
 */
abstract class Product {

    /**
     * @var int|null The product ID
     */
    protected ?int $id;

    /**
     * @var string The product name
     */
    protected string $name;

    /**
     * @var string The product description
     */
    protected string $description;

    /**
     * @var float The product price (excluding tax)
     */
    protected float $price;

    /**
     * @var int The available product quantity
     */
    protected int $quantity;

    /**
     * Gets the product ID.
     * 
     * @return int The product ID
     */
    public abstract function getId(): int;

    /**
     * Sets the product ID.
     * 
     * @param int $id The product ID
     */
    public abstract function setId(int $id): void;

    /**
     * Gets the product name.
     * 
     * @return string The product name
     */
    public abstract function getName(): string;

    /**
     * Sets the product name.
     * 
     * @param string $name The product name
     */
    public abstract function setName(string $name): void;

    /**
     * Gets the product description.
     * 
     * @return string The product description
     */
    public abstract function getDescription(): string;

    /**
     * Sets the product description.
     * 
     * @param string $description The product description
     */
    public abstract function setDescription(string $description): void;

    /**
     * Gets the product price (excluding tax).
     * 
     * @return float The product price
     */
    public abstract function getPrice(): float;

    /**
     * Sets the product price.
     * 
     * @param float $price The product price
     */
    public abstract function setPrice(float $price): void;

    /**
     * Gets the available product quantity.
     * 
     * @return int The product quantity
     */
    public abstract function getQuantity(): int;

    /**
     * Sets the product quantity.
     * 
     * @param int $quantity The product quantity
     */
    public abstract function setQuantity(int $quantity): void;

    protected function getTaxRate(): float
    {
        $config = ConfigurationManager::getInstance();
        return (float) $config->get('VAT');
    }

    /**
     * Calculates the product price including tax.
     * 
     * @return float The product price including tax
     */
    public function calculatePriceTaxInclude(): float
    {   
        $taxRate = $this->getTaxRate();
        return $this->price * (1 + $taxRate);
    }


    /**
     * Checks if the stock is sufficient.
     * 
     * @return bool True if the stock is sufficient, false otherwise
     */
    public abstract function checkStock(): bool;

      /**
     * Calcul the delivery tax price with the weight of the product
     *
     * @return float
     */
    public abstract function calculateDeliveryTax(): float;

    /**
     * Return an array of all details about product
     *
     * @return array
     */
    public abstract function showDetails(): array;


}
