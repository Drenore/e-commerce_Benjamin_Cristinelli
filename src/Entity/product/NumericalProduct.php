<?php

namespace Flowup\ECommerce\Entity\Product;

use InvalidArgumentException;


/**
 * Class NumericalProduct
 * 
 * Represents a digital product with concrete implementations of the Product methods.
 */
class NumericalProduct extends Product {

    /**
     * Link where you download numerical product
     *
     * @var string
     */
    private string $downloadLink; 

    /**
     * Size of the file to download, in MB
     *
     * @var float
     */
    private float $fileSize;

    /**
     * file format, jpg, zip, etc
     *
     * @var string
     */
    private string $fileFormat;

    /**
     * NumericalProduct constructor.
     * 
     * @param int|null $id The product ID
     * @param string $name The product name
     * @param string $description The product description
     * @param float $price The product price (excluding tax)
     * @param int $quantity The available quantity of the digital product
     * @param string $downloadLink where to download the file 
     * @param float $fileSize Size of the file to download
     * @param string $fileFormat type of file to download
     */
    public function __construct(?int $id, string $name, string $description, float $price, int $quantity, float $fileSize, string $fileFormat) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->downloadLink = $this->generateDownloadLink();
        $this->fileSize = $fileSize;
        $this->fileFormat = $fileFormat;
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
     * Gets the download link of the numerical product.
     * 
     * @return string The download link
     */
    public function getDownloadLink(): string {
        return $this->downloadLink;
    }

    /**
     * Sets the download link of the numerical product.
     * 
     * @param string $downloadLink The download link
     */
    public function setDownloadLink(string $downloadLink): void {
        $this->downloadLink = $downloadLink;
    }

    /**
     * Gets the file size of the numerical product.
     * 
     * @return float The file size in megabytes (MB)
     */
    public function getFileSize(): float {
        return $this->fileSize;
    }

    /**
     * Sets the file size of the numerical product.
     * 
     * @param float $fileSize The file size in megabytes (MB)
     * @throws InvalidArgumentException If the file size is negative
     */
    public function setFileSize(float $fileSize): void {
        if ($fileSize < 0) {
            throw new InvalidArgumentException("File size cannot be negative.");
        }
        $this->fileSize = $fileSize + "MB";
    }

    /**
     * Gets the file format of the numerical product.
     * 
     * @return string The file format (e.g., PDF, MP4, ZIP)
     */
    public function getFileFormat(): string {
        return $this->fileFormat;
    }

    /**
     * Sets the file format of the numerical product.
     * 
     * @param string $fileFormat The file format (e.g., PDF, MP4, ZIP)
     */
    public function setFileFormat(string $fileFormat): void {
        $this->fileFormat = $fileFormat;
    }

    public function checkStock(): bool {
        return $this->quantity > 0;
    }

    public function calculateDeliveryTax(): float {
        return 0.0; // Numerical product doens't have a price on delivery
    }
    public function showDetails(): array
    {
        return [
        'id' => $this->getId(), 
        'name' => $this->getName(), 
        'description' => $this->getDescription(), 
        'price' => $this->getPrice(), 
        'quantity' => $this->getQuantity(),
        'downloadLink' => $this->getDownloadLink(), 
         'fileSize' => $this->getFileSize(), 
         'fileFormat' => $this->getFileFormat(), 
         'PriceTaxInc' => $this->calculatePriceTaxInclude(), 
         'inStock' => $this->checkStock()];
    }

    /**
     * Generate a random url for download
     *
     * @return string
     */
    public function generateDownloadLink(): string {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $url = 'http://';
        for ($i= 0; $i < 15; $i++){
            $url .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $url .= ".com";
    }



}
