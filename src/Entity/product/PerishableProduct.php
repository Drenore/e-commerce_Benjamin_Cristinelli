<?php

require_once 'Product.php';

/**
 * Class PerishableProduct
 * 
 * Represents a perishable product with concrete implementations of the Product methods.
 */
class PerishableProduct extends Product {

    /**
     * Expiration date of the perishable product
     *
     * @var DateTime
     */
    private DateTime $expirationDate;

    /**
     * Temperature of the storage to keep our perishable product 
     *
     * @var float
     */
    private float $storageTemperature;

    /**
     * PerishableProduct constructor.
     * 
     * @param int|null $id The product ID
     * @param string $name The product name
     * @param string $description The product description
     * @param float $price The product price (excluding tax)
     * @param int $quantity The available quantity of the perishable product
     * @param string $expirationDate The expiration date of the product (in 'YYYY-MM-DD' format)
     */
    public function __construct(?int $id, string $name, string $description, float $price, int $quantity, string $expirationDate, float  $storageTemperature) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->expirationDate = new DateTime($expirationDate);
        $this->storageTemperature = $storageTemperature;
    }

    public function getId(): int {
        return $this->id ?? 0;
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
     * Gets the expiration date of the perishable product.
     * 
     * @return DateTime The expiration date
     */
    public function getExpirationDate(): DateTime {
        return $this->expirationDate;
    }

    /**
     * Sets the expiration date of the perishable product.
     * 
     * @param string $expirationDate The expiration date (in 'YYYY-MM-DD' format)
     */
    public function setExpirationDate(string $expirationDate): void {
        $this->expirationDate = new DateTime($expirationDate);
    }
    /**
     * Return the storage Temperature Celsius
     *
     * @return string
     */
    public function getStorageTemperature(): string{
        return $this->storageTemperature . "C°";
    }
    
    /**
     * Set the storage temperature for a product
     *
     * @param float $storageTemperature
     * @return void
     */
    public function setStorageTemperature(float $storageTemperature): void{
        $this->storageTemperature =  $storageTemperature;
    }

    public function calculatePriceTaxInclude(): float {
        return $this->price * 1.20;
    }

    public function checkStock(): bool {
        return $this->quantity > 0;
    }

    /**
     * Calculate the delivery tax based on the weight of the product
     * (Assuming that perishable products may have specific delivery fees)
     * 
     * @return float The delivery tax
     */
    public function calculateDeliveryTax(): float {
       if(!$this->isExpired()){
        return 5.00;
       }
       return 0.0;
    }

    /**
     * Show the details of the perishable product.
     * 
     * @return array The product details
     */
    public function showDetails(): array {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'price' => $this->getPrice(),
            'quantity' => $this->getQuantity(),
            'expirationDate' => $this->getExpirationDate()->format('Y-m-d'),
            'storageTemperature' => $this->getStorageTemperature(),
            'priceTaxInc' => $this->calculatePriceTaxInclude(),
            'inStock' => $this->checkStock(),
            'isExpired' => ($this->isExpired() ? 'Expired': 'Not expired') ,
            'deliveryTax' => $this->calculateDeliveryTax(),
        ];
    }

    /**
     * Check with the today date if product is expired
     *
     * @return boolean
     */
    public function isExpired(): bool
    {
        $todayDate = new DateTime();
        if($todayDate > $this->expirationDate){
            return 1;
        }
        return 0;
    }
}
