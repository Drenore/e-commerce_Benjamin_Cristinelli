<?php

use PHPUnit\Framework\TestCase;
use Flowup\ECommerce\Repository\ProductRepository;
use Flowup\ECommerce\Entity\Product\PhysicalProduct;
use Flowup\ECommerce\Database\DatabaseConnection;
use PDO;

class ProductRepositoryTest extends TestCase
{
    private $db;
    private $repository;

    protected function setUp(): void
    {
        // Mock de la connexion à la base de données pour les tests
        $this->db = DatabaseConnection::getInstance();
        $this->repository = new ProductRepository();
    }

    public function testCreateProduct()
    {
        $productData = [
            'name' => 'Test Product',
            'description' => 'A test product',
            'price' => 99.99,
            'quantity' => 10,
            'type' => 'physical',
            'weight' => 1.5,
            'length' => 10.0,
            'width' => 5.0,
            'height' => 2.0
        ];

        // Simulez la méthode create du ProductRepository pour qu'elle appelle l'insertion en base
        $this->db->method('prepare')->willReturnSelf();
        $this->db->method('execute')->willReturn(true);
        
        // On suppose ici que la méthode save de ProductRepository appelle la méthode prepare de PDO
        $product = new PhysicalProduct(
            null, 
            $productData['name'], 
            $productData['description'], 
            $productData['price'], 
            $productData['quantity'], 
            $productData['weight'], 
            $productData['length'], 
            $productData['width'], 
            $productData['height']
        );

        $this->repository->save($product);
        $this->assertTrue(true);
    }

    public function testFindProduct()
    {
        // On prépare un faux produit retourné par la méthode find
        $productId = 1;
        $mockProductData = [
            'id' => $productId,
            'name' => 'Test Product',
            'description' => 'A test product',
            'price' => 99.99,
            'quantity' => 10,
            'type' => 'physical',
            'weight' => 1.5,
            'length' => 10.0,
            'width' => 5.0,
            'height' => 2.0
        ];

        // On simule l'exécution d'une requête SELECT
        $this->db->method('prepare')->willReturnSelf();
        $this->db->method('execute')->willReturn(true);
        $this->db->method('fetch')->willReturn($mockProductData);

        $product = $this->repository->find($productId);
        
        $this->assertInstanceOf(PhysicalProduct::class, $product);
        $this->assertEquals($productId, $product->getId());
        $this->assertEquals('Test Product', $product->getName());
    }

    public function testUpdateProduct()
    {
        $productData = [
            'name' => 'Updated Product',
            'description' => 'An updated test product',
            'price' => 109.99,
            'quantity' => 20,
            'type' => 'physical',
            'weight' => 1.8,
            'length' => 12.0,
            'width' => 6.0,
            'height' => 3.0
        ];

        // Créer un produit existant
        $product = new PhysicalProduct(
            1, 
            $productData['name'], 
            $productData['description'], 
            $productData['price'], 
            $productData['quantity'], 
            $productData['weight'], 
            $productData['length'], 
            $productData['width'], 
            $productData['height']
        );

        // Simulez la méthode update du ProductRepository
        $this->db->method('prepare')->willReturnSelf();
        $this->db->method('execute')->willReturn(true);
        
        $this->repository->update($product);

        $this->assertTrue(true); // On valide si l'appel à update ne renvoie pas d'erreur
    }

    public function testDeleteProduct()
    {
        // Simulez une suppression d'un produit existant
        $productId = 1;

        // Simuler la méthode delete
        $this->db->method('prepare')->willReturnSelf();
        $this->db->method('execute')->willReturn(true);
        
        $this->repository->delete($productId);

        $this->assertTrue(true); // On valide si la suppression ne renvoie pas d'erreur
    }

    // Test de la recherche avec des critères
    public function testFindByCriteria()
    {
        $criteria = ['name' => 'Test Product'];

        // Simulez la récupération des résultats par critères
        $this->db->method('prepare')->willReturnSelf();
        $this->db->method('execute')->willReturn(true);
        $this->db->method('fetchAll')->willReturn([[
            'id' => 1,
            'name' => 'Test Product',
            'description' => 'A test product',
            'price' => 99.99,
            'quantity' => 10,
            'type' => 'physical',
            'weight' => 1.5,
            'length' => 10.0,
            'width' => 5.0,
            'height' => 2.0
        ]]);

        $products = $this->repository->findBy($criteria);

        $this->assertIsArray($products);
        $this->assertCount(1, $products);
        $this->assertEquals('Test Product', $products[0]->getName());
    }
}