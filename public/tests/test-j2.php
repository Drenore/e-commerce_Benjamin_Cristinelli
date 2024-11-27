<?php 

require '../../vendor/autoload.php';


use Flowup\ECommerce\Entity\Cart;
use Flowup\ECommerce\Entity\User\Admin;
use Flowup\ECommerce\Entity\User\Seller;
use Flowup\ECommerce\Entity\User\Customer;
use Flowup\ECommerce\Entity\Product\PhysicalProduct;
use Flowup\ECommerce\Entity\Product\NumericalProduct;
use Flowup\ECommerce\Entity\Product\PerishableProduct;


/**
 * Creating différent product to see if they all working and then show details of all 
 * 
 */
echo "<h2> Test Produits </h2> <br/>";
$physicalProduct = new PhysicalProduct(null, "Smartphone", "A high-end smartphone", 599.99, 10, 0.2, 15, 7, 0.8);
$numericalProduct = new NumericalProduct(7, "E-book: Learn PHP", "An e-book for learning PHP programming", 19.99, 100, 5, "PDF");
$perishableProduct = new PerishableProduct(17, "Corn-dog", "product with dingueries de oignons", 7.99, 12000, "14-12-2024", 24.7);

echo "Physical product <br/>";
foreach ($physicalProduct->showDetails() as $key => $detail){
    echo $key . " : " . $detail . "<br/>";
}

echo "</br>";
echo "Numerical product <br/>";
foreach($numericalProduct->showDetails() as $key => $detail){
    echo $key . " : " . $detail . "<br/>";
}
echo "</br>";
echo "Perishable product <br/>";
foreach($perishableProduct->showDetails() as $key => $detail){
    echo $key . " : " . $detail . "<br/>";
}


/**
 * Create a cart adds two product, make a tab to see all the product in the cart and show them, at the end show total
 */
echo "<h2> Test Panier </h2> <br/>";

$cart = new Cart();
$cart->addProduct($perishableProduct, 5);  // Assuming $perishableProduct is an instance of PerishableProduct
$cart->addProduct($numericalProduct, 2);
echo "The cart contains: <br/>";
echo "<table border='1'>";
echo "<tr><th>Product Name</th><th>Price</th><th>Quantity</th><th>Total</th></tr>";

// Loop through the cart articles and display product details
foreach ($cart->getArticles() as $article) {
    echo "<tr>";
    
    // Displaying the product name, price, quantity, and total for each product in the cart
    echo "<td>" . $article['product']->getName() . "</td>";  // Assuming getName() method exists in Product class
    echo "<td>" . $article['product']->getPrice() . "€</td>";  // Assuming getPrice() method exists
    echo "<td>" . $article['quantity'] . "</td>";  // Displaying the quantity
    echo "<td>" . $article['product']->getPrice() * $article['quantity'] . "€</td>";  // Total price for this product
    
    echo "</tr>";
}

echo "</table>";
echo "Total: " . $cart->calculateTotal() . "€";  // Assuming calculateTotal() method sums up the total cart price

/**
 * 
 */
echo "<h2> Test Users </h2> <br/>";


$customer = new Customer("John Doe", "john.doe@example.com", "securepassword123", "123 Elm Street", $cart);
echo "Customer: " . $customer->getName() . " - " . $customer->getEmail() . " - " . $customer->getDeliveryAddress() . "<br/>";

// Test for Admin
$admin = new Admin("Admin User", "admin@example.com", "adminpassword", 1, new DateTime());
echo "Admin: " . $admin->getName() . " - " . $admin->getAccessLevel() . "<br/>";

// Test for Seller
$seller = new Seller("Seller User", "seller@example.com", "sellerpassword", "Seller's Shop", 10.0);
echo "Seller: " . $seller->getName() . " - " . $seller->getStore() . " - Commission: " . $seller->getCommission() . "%<br/>";
