<?php

namespace Flowup\ECommerce\Entity;

use Flowup\ECommerce\Entity\Product\Product;

class Category {

    /**
     * @var int The category ID
     */
    private int $id;

    /**
     * @var string The category name
     */
    private string $name;

    /**
     * @var string The category description
     */
    private string $description;

    /**
     * @var Product[] List of products in the category
     */
    private array $products = [];

    /**
     * Category constructor.
     * 
     * @param int $id The category ID
     * @param string $name The category name
     * @param string $description The category description
     */
    public function __construct(int $id, string $name, string $description) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * Adds a product to the category.
     * 
     * @param Product $product The product to add
     */
    public function addProduct(Product $product): void {
        $this->products[] = $product;
    }

    /**
     * Removes a product from the category.
     * 
     * @param Product $product The product to remove
     */
    public function removeProduct(Product $product): void {
        foreach ($this->products as $key => $prod) {
            if ($prod === $product) {
                unset($this->products[$key]);
                break;
            }
        }
    }

    /**
     * Returns the list of products in the category.
     * 
     * @return Product[] Array of products in the category
     */
    public function listProducts(): array {
        return $this->products;
    }

    // Getters and Setters
    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }
}
?>
