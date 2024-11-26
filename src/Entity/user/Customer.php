<?php

require_once "User.php";  // Since both Admin.php and User.php are in the same folder
include_once "C:/wamp64/www/e-commerce/src/Entity/cart/Cart.php";

/**
 * Class Customer
 *
 * Represents a customer with properties such as delivery address, cart, and order history.
 * This class extends from the User class and adds functionality specific to customers.
 */
class Customer extends User {

    /**
     * @var string The delivery address of the customer
     */
    private string $deliveryAddress;

    /**
     * @var Cart The cart associated with the customer
     */
    private Cart $cart;

    /**
     * @var array The order history of the customer
     */
    private array $ordersHistory = [];

    /**
     * Customer constructor.
     *
     * Initializes a new customer object with user details, delivery address, and a cart.
     *
     * @param string $name The customer's name
     * @param string $email The customer's email address
     * @param string $password The customer's password
     * @param string $deliveryAddress The delivery address of the customer
     * @param Cart $cart The cart associated with the customer
     */
    public function __construct(string $name, string $email, string $password, string $deliveryAddress, Cart $cart) {
        parent::__construct($name, $email, $password);
        $this->deliveryAddress = $deliveryAddress;
        $this->cart = $cart;
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
     * Get the delivery address of the customer.
     *
     * @return string The customer's delivery address
     */
    public function getDeliveryAddress(): string {
        return $this->deliveryAddress;
    }

    /**
     * Set the delivery address of the customer.
     *
     * @param string $deliveryAddress The new delivery address
     * @return void
     */
    public function setDeliveryAddress(string $deliveryAddress): void {
        $this->deliveryAddress = $deliveryAddress;
    }

    /**
     * Get the cart associated with the customer.
     *
     * @return Cart The customer's cart
     */
    public function getCart(): Cart {
        return $this->cart;
    }

    /**
     * Set the cart for the customer.
     *
     * @param Cart $cart The new cart associated with the customer
     * @return void
     */
    public function setCart(Cart $cart): void {
        $this->cart = $cart;
    }

    /**
     * Create a new order from the items in the cart.
     * This method is a placeholder for now.
     *
     * @return void
     */
    public function makeOrder(): void {
        // Method to create an order from the cart (empty for now)
    }

    /**
     * Check the order history of the customer.
     *
     * @return array The order history
     */
    public function checkOrderHistory(): array {
        return $this->ordersHistory;
    }

    /**
     * Add an order to the customer's order history.
     * This method currently returns true as a placeholder.
     *
     * @return bool True if the order was added successfully
     */
    public function addOrderHistory(): bool {
       // Placeholder to add an order to the history
       return true;
    }
}
?>
