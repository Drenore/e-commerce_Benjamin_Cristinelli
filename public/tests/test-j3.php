<?php

require '../../vendor/autoload.php';

use Flowup\ECommerce\Config\ConfigurationManager;
use Flowup\ECommerce\Factory\ProductFactory;

$productFactory = new ProductFactory();

$arrPhysicalProd =  [
    "id" => null,
    "name" => "Smartphone",
    "description" => "A high-end smartphone",
    "price" => 599.99,
    "quantity" => 10,
    "weight" => 0.2,
    "length" => 15,
    "width" => 7,
    "height" => 0.8
];
$arrNumericalProduct =  [
    "id" => 12,
    "name" => "E-book: Learn PHP",
    "description" => "An e-book for learning PHP programming",
    "price" => 19.99,
    "quantity" => 100,
    "fileSize" => 5,
    "fileFormat" => "PDF",
];
$arrPerishableProduct = [
    "id" => 24,
    "name" => "Corn-dog",
    "description" => "product with dingueries de oignons",
    "price" => 7.99,
    "quantity" => 12000,
    "expirationDate" => "14-12-2024",
    "storageTemperature" => 12.6
];
$physicalProduct = $productFactory->createProduct('Physical product', $arrPhysicalProd);
$numericalProduct = $productFactory->createProduct('Numerical product', $arrNumericalProduct);
$perishableProduct = $productFactory->createProduct('Perishable product', $arrPerishableProduct);


foreach ($physicalProduct->showDetails() as $key => $detail) {
    echo $key . " : " . $detail . "<br/>";
}
echo "<br/>";
foreach ($numericalProduct->showDetails() as $key => $detail) {
    echo $key . " : " . $detail . "<br/>";
}
echo "<br/>";
foreach ($perishableProduct->showDetails() as $key => $detail) {
    echo $key . " : " . $detail . "<br/>";
}
echo "<br/>";
echo "<br/>";

$config = ConfigurationManager::getInstance();
print_r($config->getAll());
echo "<br/>";
echo "<br/>";
$config->set('contactEmail', 'jesuistropfort@samarche.com');
print_r($config->getAll());
