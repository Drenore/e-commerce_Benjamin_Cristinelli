<?php 

require __DIR__ . '/vendor/autoload.php';


include "../src/Entity/product/Product.php";
include "../src/Entity/User.php";

$product = new Product("Laptop", "High-performance laptop for professionals.", 999.99, 10);

$product->setId(1);
$product->setName("Machine de guerre");
$product->setDescription("Une fusée mon copain tu vas voir le missile");
$product->setPrice(745,34);
$product->setQuantity(17);



$user = new User("John Doe","johndoe@example.com","securePassword123");
$datetime = new DateTime();
$currentDateTime = $datetime->format('Y-m-d H:i:s');

$user->setId(1);
$user->setName("Toto Le bogoss");
$user->setEmail("toto@bogoss.com");
$user->setPassword("Toto1234");
$user->setRegisterDate($datetime);




echo $product->calculatePriceTaxInclude() . "€";
echo "</br>";
echo $product->checkStock();
echo "</br>";
echo $user->passwordVerify("Toto4321");
echo "</br>";

$user->updateUserProfile(
    "Otto le moche",
    "otto@lemochedu17.com",
    "Otto1234"
);
var_dump($product);
var_dump($user);
