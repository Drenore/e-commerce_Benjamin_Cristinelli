<?php

namespace Flowup\ECommerce\Repository;

use PDO;
use PDOException;
use InvalidArgumentException;
use Flowup\ECommerce\Entity\Product\Product;
use Flowup\ECommerce\Factory\ProductFactory;
use Flowup\ECommerce\Database\DatabaseConnection;
use Flowup\ECommerce\Entity\Product\PhysicalProduct;
use Flowup\ECommerce\Repository\RepositoryInterface;
use Flowup\ECommerce\Entity\Product\NumericalProduct;
use Flowup\ECommerce\Entity\Product\PerishableProduct;


/**
 * Contains all methods to make add filter of product elements in Database
 */
class ProductRepository implements RepositoryInterface
{

    private PDO $db;


    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance();
    }
    /**
     * Find a product by his id and return it instanced if he's existing or null if not
     *
     * @param integer $id
     * @return Product|null
     */
    public function find(int $id): ?Product
    {
        $request = $this->db->prepare('SELECT * FROM product WHERE id= :id ');
        $request->bindParam(":id", $id, PDO::PARAM_INT);
        $request->execute();

        $result = $request->fetch();

        if (!$result) {
            return NULL;
        }
        $product = ProductFactory::createProduct($result['type'], $result);

        return $product ?  $product : null;
    }
    /**
     * Find all product instance them and return an array of product instanced
     *
     * @return array
     */
    public function findAll(): array
    {
        $products = [];

        $request = $this->db->prepare('SELECT * FROM product');
        $request->execute();
        $results = $request->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($results)) {
            foreach ($results as $product) {
                var_dump($results);
                $products[] = ProductFactory::createProduct($product['type'], $product);
            }
            return $products;
        }
        return [];
    }
    /**
     * Create a method to register a product in db, depends on the type, return the id of the product registered
     *
     * @param Product $product
     * @return integer
     */
    public function save(object $entity): int
    {
        if (!$entity instanceof Product) {
            throw new InvalidArgumentException('The entity need to be a product');
        }
        /**
         * Get type of the class registered
         */
        $type = get_class($entity);

        $shortClassName = basename(str_replace('\\', '/', $type));

        /**
         * Make an array with the common fields of all the prodruc
         */
        $commonFields = [
            'name' => $entity->getName(),
            'description' => $entity->getDescription(),
            'price' => $entity->getPrice(),
            'quantity' => $entity->getQuantity(),
            'type' => strtolower($shortClassName),
        ];

        /**
         * Create an array who registered all the specifics files linked to the type of the product
         */
        $specificFields = [];
        /**
         * Set all the value to the specificsFields array to set them for add in db
         */
        if ($entity instanceof PhysicalProduct) {
            $specificFields = [
                'weight' => $entity->getWeight(),
                'length' => $entity->getLength(),
                'width' => $entity->getWidth(),
                'height' => $entity->getHeight(),
            ];
        } elseif ($entity instanceof NumericalProduct) {
            $specificFields = [
                'fileSize' => $entity->getFileSize(),
                'fileFormat' => $entity->getFileFormat(),
            ];
        } elseif ($entity instanceof PerishableProduct) {
            $specificFields = [
                'expirationDate' => $entity->getExpirationDate(),
                'storageTemperature' => $entity->getStorageTemperature(),
            ];
        }
        /**
         * Merge the commong fields and specificFields to add them in an unique array to make our request adds
         * 
         */
        $fields = array_merge($commonFields, $specificFields);
        /**
         * get all the keys link to the name of the column of our table
         */
        $columns = implode(', ', array_keys($fields));

        /**
         * Set all our :value to make sure we can bind all correctly
         */
        $placeholders = ':' . implode(', :', array_keys($fields));
        try {

            /**
             * Prepare the request with our $columns, name of table, and $placeholders var to bind 
             */
            $request = $this->db->prepare("INSERT INTO product ($columns) VALUES ($placeholders)");
            /**
             * Bind our value
             */
            foreach ($fields as $key => $value) {
                $request->bindValue(":$key", $value);
            }
            /**
             * Execute the request
             */
            $request->execute();
        } catch (PDOException $e) {
            die('The request to add product doesn\'t work correctly : ' . $e);
        }
        /**
         * Get the last id inserted in product table and return it
         */
        return (int) $this->db->lastInsertId();
    }

    /**
     * Update a product
     *
     * @param object $entity
     * @return void
     */
    public function update(object $entity): void
    {
        if (!$entity instanceof Product) {
            throw new InvalidArgumentException('The entity need to be a product');
        }
        $type = get_class($entity);
        $shortClassName = basename(str_replace('\\', '/', $type));
        $id = $entity->getId();
        /**
         * Make an array with the common fields of all the prodruc
         */
        $commonFields = [
            'name' => $entity->getName(),
            'description' => $entity->getDescription(),
            'price' => $entity->getPrice(),
            'quantity' => $entity->getQuantity(),
            'type' => strtolower($shortClassName),
        ];

        
        /**
         * Create an array who registered all the specifics files linked to the type of the product
         */
        $specificFields = [];
        /**
         * Set all the value to the specificsFields array to set them for add in db
         */
        if ($entity instanceof PhysicalProduct) {
            $specificFields = [
                'weight' => $entity->getWeight(),
                'length' => $entity->getLength(),
                'width' => $entity->getWidth(),
                'height' => $entity->getHeight(),
            ];
        } elseif ($entity instanceof NumericalProduct) {
            $specificFields = [
                'fileSize' => $entity->getFileSize(),
                'fileFormat' => $entity->getFileFormat(),
            ];
        } elseif ($entity instanceof PerishableProduct) {
            $specificFields = [
                'expirationDate' => $entity->getExpirationDate(),
                'storageTemperature' => $entity->getStorageTemperature(),
            ];
        }
        /**
         * Merge the commong fields and specificFields to add them in an unique array to make our request adds
         * 
         */
        $fields = array_merge($commonFields, $specificFields);

        /**
         * create a string who set a table with a :key value 
         */
        $setClause = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($fields)));
        try {

            /**
             * Prepare the request with our $columns, name of table, and $placeholders var to bind 
             */
            $request = $this->db->prepare("UPDATE product SET $setClause WHERE id = :id");
            /**
             * Bind our value
             */
            foreach ($fields as $key => $value) {
                $request->bindValue(":$key", $value);
            }
            // Bind the ID of the product
            $request->bindParam(':id', $id);
            /**
             * Execute the request
             */
            $request->execute();
        } catch (PDOException $e) {
            die('The request to update product doesn\'t work correctly : ' . $e);
        }
    }
    /**
     * Function to delete 
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {

        try {
            $request = $this->db->prepare('DELETE * FROM product WHERE id = :id');
            $request->bindParam(':id', $id, PDO::PARAM_INT);
        } catch (\PDOException $e) {
            die('The delete doesnt work :' . $e);
        }
    }

    /**
     * Find a product with one or more specific criteria
     *
     * @param array $criteria
     * @return array
     */
    public function findBy(array $criteria): array
    {
        $query = 'SELECT * FROM product';
        $params = [];
        $conditions = [];

        // Construct the where element depends on what contains in criteria
        foreach ($criteria as $key => $value) {
            $conditions[] = "$key = :$key";
            $params[":$key"] = $value;
        }

        if (!empty($conditions)) {
            $query .= ' WHERE ' . implode(' AND ', $conditions);
        }
        $request = $this->db->prepare($query);
        $request->execute($params);

        $results = $request->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        foreach ($results as $product) {
            $products[] = ProductFactory::createProduct($product['type'], $product);
        }
        return $products;
    }
}
