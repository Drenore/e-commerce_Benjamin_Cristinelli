<?php

require_once 'Product.php';

/**
 * Class ProduitPhysique
 * 
 * Represents a physical product with concrete implementations of the Product methods.
 */
class PhysicalProduct extends Product {

    /**
     * The weight in kg of the product
     *
     * @var float 
     */
    private float $weight;

    /**
     * Length of product in cm
     *
     * @var float
     */
    private float $length;

    /**
     * Width of the physical product in cm
     *
     * @var float
     */
    private float $width;

    /**
     * height of the physical product cm
     *
     * @var float
     */
    private float $height;

    /**
     * ProduitPhysique constructor.
     * 
     * @param int|null $id The product ID
     * @param string $name The product name
     * @param string $description The product description
     * @param float $price The product price (excluding tax)
     * @param int $quantity The product quantity
     */
    public function __construct(?int $id, string $name, string $description, float $price, int $quantity, float $weight, float $length, float $width, float $height) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->weight = $weight;
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
    }

    public function getId(): int {
        return $this->id ?? 0; // Default to 0 if ID is null
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function setPrice(float $price): void {
        if ($price < 0) {
            throw new InvalidArgumentException("The price cannot be zero or negative.");
        }
        $this->price = $price;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void {
        if ($quantity < 0) {
            throw new InvalidArgumentException("Quantity cannot be less than 0.");
        }
        $this->quantity = $quantity;
    }
    /**
     * Get the value of weight for the product
     *
     * @return float
     */
    public function getWeight(): string {
        return $this->weight . 'kg';
    }
    /**
     * Set the class value of weight for this physical product
     *
     * @param float $weight
     * @return void
     */
    public function setWeight(float $weight): void {
        $this->weight = $weight;
    }

    /**
     * get length of the product
     *
     * @return float
     */

    public function getLength(): string {
        return $this->length . "cm";
    }
    /**
     * set length for the physical product
     *
     * @param float $length
     * @return void
     */

    public function setLength(float $length): void {
        $this->length = $length;
    }

    /**
     *  get the width of physical product
     *
     * @return float
     */
    public function getWidth(): string {
        return $this->width . "cm";
    }
    
    /**
     * Set width of the physical product
     *
     * @param float $width
     * @return void
     */
    public function setWidth(float $width): void {
        $this->width = $width;
    }


    /**
     * Get the height of the physical product
     *
     * @return float
     */
    public function getHeight(): string {
        return $this->height . "cm";;
    }
    /**
     * Set the height
     *
     * @param float $height
     * @return void
     */
    public function setHeight(float $height): void {
        $this->height = $height;
    }


    public function calculatePriceTaxInclude(): float {
        return $this->price * 1.20; // Adds 20% tax
    }

    public function checkStock(): bool {
        return $this->quantity > 0;
    }

    public function calculateDeliveryTax(): float {
        if ($this->weight >= 10) {
            return 4.99;
        } elseif ($this->weight >= 5) {
            return 3.99;
        } else {
            return 2.99;
        }
    }
    
    public function showDetails(): array
    {
        return ['id' => $this->getId(), 
        'name' => $this->getName(), 
        'description' => $this->getDescription(),
         "priceTaxExc" => $this->getPrice(), 
         "quantity" => $this->getQuantity(),
          "weight" => $this->getWeight(), 
          "length" => $this->getLength(), 
          "witdh" => $this->getWidth(), 
          "height" => $this->getHeight(), 
          "PriceTaxInc" => $this->calculatePriceTaxInclude(), 
          "inStock" => $this->checkStock(), 
          "deliveryTax" => $this->calculateDeliveryTax()];
    }

    /**
     * Calculate the volume of our physical product in cm3
     *
     * @return float
     */
    public function volumeCalculation(): float{
        return $this->length * $this->height * $this->width;
    }


  
}


