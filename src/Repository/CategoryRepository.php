<?php

namespace Flowup\ECommerce\Repository;

use PDO;
use InvalidArgumentException;
use Flowup\ECommerce\Entity\Category;
use Flowup\ECommerce\Database\DatabaseConnection;
use Flowup\ECommerce\Repository\RepositoryInterface;

class CategoryRepository implements RepositoryInterface{

    private PDO $db;


    public function __construct(){
        $this->db = DatabaseConnection::getInstance();
    
    }

    /**
     * Find a Category by his id and return it instanced if he's existing or null if not
     *
     * @param integer $id
     * @return category|null
     */
    public function find(int $id): ?Category
    {
        $request = $this->db->prepare('SELECT * FROM category WHERE id= :id ');
        $request->bindParam(":id", $id, PDO::PARAM_INT);
        $request->execute();
        
        $category = $request->fetch();

        if(!$category) {
            return NULL;
        }
        $category = new Category($category['id'], $category['name'], $category['description']);

        return $category ?  $category : null;
    } 

    public function findAll(): array
    {
        $category = [];

        $request = $this->db->prepare('SELECT * FROM category');
   
        $request->execute();
        $results = $request->fetchAll();
   

        if(!empty($results)){
            foreach($results as $category){
                $category[] = new Category($category['id'], $category['name'], $category['description']);
            } 
            return $category;         
        }
        return [];
    }

    public function save(object $entity): int
    {
        if (!$entity instanceof Category) {
            throw new InvalidArgumentException('The entity need to be a category');
        }
        $name = $entity->getName();
        $description = $entity->getDescription();
        $request = $this->db->prepare("INSERT INTO category (name, description) VALUES (:name, :description)");
        $request->bindParam(':name',   $name, PDO::PARAM_STR);
        $request->bindParam(':description', $description, is_null($entity->getDescription()) ? PDO::PARAM_NULL : PDO::PARAM_STR);

        try{
            $request->execute();
        } catch (\PDOException $e){
            throw new \Exception('The save of category not working : ' . $e->getMessage());
        }
        return (int) $this->db->lastInsertId();
    }

    

    public function update(object $entity): void
    {
        if (!$entity instanceof Category) {
            throw new InvalidArgumentException('The entity need to be a Category');
        }
        $name = $entity->getName();
        $description = $entity->getDescription();
        $id = $entity->getId();
        $paramDescriptionType = is_null($description) ? PDO::PARAM_NULL : PDO::PARAM_STR;
        $request = $this->db->prepare("UPDATE category SET name = :name, description = :description WHERE id = :id");
        $request->bindParam(':name', $name, PDO::PARAM_STR);
        $request->bindParam(':description', $description, $paramDescriptionType);
        $request->bindParam(':id',$id,  PDO::PARAM_INT);        
        try{
            $request->execute();
        } catch (\PDOException $e){
            throw new \Exception('The update of category not working : ' . $e->getMessage());
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
        $request = $this->db->prepare('DELETE * FROM category WHERE id = :id');
        $request->bindParam(':id', $id, PDO::PARAM_INT);
        try {
            $request->execute();
        } catch (\PDOException $e) {
            die('The delete doesnt work :' .$e->getMessage());
        }
    }

            /**
     * Find a category with one or more specific criteria
     *
     * @param array $criteria
     * @return array
     */
    public function findBy(array $criteria): array
    {
        $query = 'SELECT * FROM category';
        $params = [];
        $conditions = [];

        // Construct the where element depends on what contains in criteria
        foreach ($criteria as $key => $value){
            $conditions[] = "$key = :$key";
            $params[":$key"] = $value;
        }

        if (!empty($conditions)){
            $query .= ' WHERE ' . implode(' AND ', $conditions);
        }
        $request = $this->db->prepare($query);
        var_dump($request);
        $request->execute($params);
       
        $results = $request->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];
        
        foreach($results as $category){
            $categories[] =  new Category($category['id'], $category['name'], $category['description']);
        }
        
        return $categories;
    }

    
}