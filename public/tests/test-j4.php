<?php 

require '../../vendor/autoload.php';

use Flowup\ECommerce\Entity\Category;
use Flowup\ECommerce\Entity\User\Admin;
use Flowup\ECommerce\Factory\UserFactory;
use Flowup\ECommerce\Repository\UserRepository;
use Flowup\ECommerce\Database\DatabaseConnection;
use Flowup\ECommerce\Repository\ProductRepository;
use Flowup\ECommerce\Repository\CategoryRepository;
use Flowup\ECommerce\Entity\Product\PhysicalProduct;


$db = DatabaseConnection::getInstance();

if($db){
    echo "The database connexion is working <br/>";
} else {
    echo "The connexion is shitty not working <br/>";
}




// Initialisez la connexion à la base de données et le repository
$productRepository = new ProductRepository();

// 1. Test de création d'un produit
echo "Testing Create Product:\n";
$productData = [
    'name' => 'Test Product',
    'description' => 'A test product description',
    'price' => 99.99,
    'quantity' => 10,
    'type' => 'physical',
    'weight' => 1.5,
    'length' => 10.0,
    'width' => 5.0,
    'height' => 2.0
];

$product = new PhysicalProduct(
    null, // ID sera auto-incrémenté
    $productData['name'],
    $productData['description'],
    $productData['price'],
    $productData['quantity'],
    $productData['weight'],
    $productData['length'],
    $productData['width'],
    $productData['height']
);

// Sauvegarder le produit
$productId = $productRepository->save($product);
echo "Product created successfully!\n";

// 2. Test de la lecture d'un produit (find)
echo "\nTesting Find Product:\n";
$product = $productRepository->find($productId);
if ($product) {
    echo "Product found: " . $product->getName() . "\n";
} else {
    echo "Product not found.\n";
}

// 3. Test de mise à jour d'un produit (update)
echo "\nTesting Update Product:\n";
$productToUpdate = $productRepository->find($productId);
if ($productToUpdate) {
    $productToUpdate->setName('Updated Test Product');
    $productToUpdate->setDescription('Updated description');
    $productToUpdate->setPrice(109.99);
    $productToUpdate->setQuantity(20);

    $productRepository->update($productToUpdate);
    echo "Product updated successfully!\n";
} else {
    echo "Product to update not found.\n";
}
$allProduct = $productRepository->findAll();

// 5. Test de recherche par critères (findBy)
echo "\nTesting Find By Criteria:\n";
$criteria = ['name' => 'Updated Test Product'];
$products = $productRepository->findBy($criteria);

if (count($products) > 0) {
   
    echo "Found " . count($products) . " product(s) matching criteria:\n";
    foreach ($products as $prod) {
        echo "- " . $prod->getName() . "\n";
    }
} else {
    echo "No products found matching criteria.\n";
}



echo "\nTesting Delete Product:\n";
$productIdToDelete = $productId;  // Remplacez par un ID valide à supprimer
$productRepository->delete($productId);
echo "Product deleted successfully!\n";


// Create a category 

$categoryRepository = new CategoryRepository();

$categoryDetail = [
    'name' => 'Developpment',
    'description' => 'Developpement category to set product with'
];

$category = new Category(null, $categoryDetail['name'], $categoryDetail['description']);

$categoryId = $categoryRepository->save($category);
echo "Category created successfully!<br/>\n";

// 2. Test de la lecture d'un categoy (find)
echo "\nTesting Find Category \n<br/>";
$category = $categoryRepository->find($categoryId);
if ($category) {
    echo "Product found: " . $category->getName() . "\n <br/>";
} else {
    echo "Product not found.\n";
}
print_r($category);

// 3. Test de mise à jour d'un category (update)
echo "\nTesting Update Category:\n";
$categoryToUpdate = $categoryRepository->find($categoryId);
if ($categoryToUpdate) {
    $categoryToUpdate->setName('Magic');
    $categoryToUpdate->setDescription('Magic materiels');

    $categoryRepository->update($categoryToUpdate);
    echo "Category updated successfully!\n<br/>";
} else {
    echo "Category to update not found.\n<br/>";
}

/**test findAll */
$allCategory = $categoryRepository->findAll();

print_r($allCategory);

/**test find by */
echo "\nTesting Find By Criteria:\n<br/>";
$criteria = ['name' => 'Magic'];
$categories = $categoryRepository->findBy($criteria);

if (count($categories) > 0) {
   
    echo "Found " . count($categories) . " product(s) matching criteria:\n<br/>";
    foreach ($categories as $categ) {
        echo "- " . $categ->getName() . "\n";
    }
} else {
    echo "No Category found matching criteria.\n<br/>";
}


// Initialisez le repository pour les utilisateurs
$userRepository = new UserRepository();

// 1. Test de création d'un utilisateur
echo "Testing Create User:\n";
$userData = [
    'id' => null,
    'name' => 'John Doe',
    'email' => 'johndoe@example.com',
    'password' => password_hash('secret', PASSWORD_BCRYPT),
    'role' => 'admin', 
    'accessLevel' => 3,
    'lastConnection' => new DateTime()
];

$user = UserFactory::createUser($userData['role'], $userData);
$userId = $userRepository->save($user);
echo "User created successfully with ID: $userId\n";

// 2. Test de la lecture d'un utilisateur (find)
echo "\nTesting Find User:\n";
$user = $userRepository->find($userId);
if ($user) {
    echo "User found: " . $user->getName() . " (" . $user->getEmail() . ")\n";
} else {
    echo "User not found.\n";
}

// 3. Test de mise à jour d'un utilisateur (update)
echo "\nTesting Update User:\n";
$userToUpdate = $userRepository->find($userId);
if ($userToUpdate) {
    $userToUpdate->setName('John Updated');
    $userToUpdate->setEmail('johnupdated@example.com');
    $userRepository->update($userToUpdate);
    echo "User updated successfully!\n";
} else {
    echo "User to update not found.\n";
}

// 4. Test de récupération de tous les utilisateurs (findAll)
echo "\nTesting Find All Users:\n";
$allUsers = $userRepository->findAll();
var_dump($allUsers);

// 5. Test de recherche par critères (findBy)
echo "\nTesting Find By Criteria:\n";
$criteria = ['email' => 'johnupdated@example.com'];
$users = $userRepository->findBy($criteria);

if (count($users) > 0) {
    echo "Found " . count($users) . " user(s) matching criteria:\n";
    foreach ($users as $usr) {
    
        echo "- " . $usr->getName() . " (" . $usr->getEmail() . ")\n";
    }
} else {
    echo "No users found matching criteria.\n";
}

// 6. Test de suppression d'un utilisateur (delete)
echo "\nTesting Delete User:\n";
$userRepository->delete($userId);
echo "User deleted successfully!\n";

// Vérifiez si l'utilisateur a été supprimé
echo "\nVerifying User Deletion:\n";
$deletedUser = $userRepository->find($userId);
if ($deletedUser) {
    echo "User not deleted: " . $deletedUser->getName() . "\n";
} else {
    echo "User successfully deleted.\n";
}





?>

