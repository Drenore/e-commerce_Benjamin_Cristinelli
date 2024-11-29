<?php 


namespace Flowup\ECommerce\Repository;

use PDO;
use DateTime;
use PDOException;
use InvalidArgumentException;
use Flowup\ECommerce\Entity\User\User;
use Flowup\ECommerce\Entity\User\Admin;
use Flowup\ECommerce\Entity\User\Seller;
use Flowup\ECommerce\Factory\UserFactory;
use Flowup\ECommerce\Entity\User\Customer;
use Flowup\ECommerce\Database\DatabaseConnection;
use Flowup\ECommerce\Repository\RepositoryInterface;


class UserRepository implements RepositoryInterface{
    
    private PDO $db;
    public function __construct(){
        $this->db = DatabaseConnection::getInstance();
    
    }

     /**
     * Find a product by his id and return it instanced if he's existing or null if not
     *
     * @param integer $id
     * @return User|null
     */
    public function find(int $id): ?User
    {
        $request = $this->db->prepare('SELECT * FROM user WHERE id= :id ');
        $request->bindParam(":id", $id, PDO::PARAM_INT);
        $request->execute();
        
        $result = $request->fetch();

        if(!$result) {
            return NULL;
        }
        $user = UserFactory::createUser($result['role'], $result);

        return $user ?  $user : null;
    }

     /**
     * Find all product instance them and return an array of product instanced
     *
     * @return array
     */
    public function findAll(): array
    {
        $user = [];

        $request = $this->db->prepare('SELECT * FROM user');
        $request->execute();
        $results = $request->fetchAll();
        foreach($results as $user){
            $user[] = UserFactory::createUser($user['role'], $user);
        }

        return $user;
    }

     /**
     * Create a method to register a user in db, depends on the type, return the id of the user registered
     *
     * @param User $entity
     * @return integer
     */
    public function save(object $entity): int
    {
        if (!$entity instanceof User) {
            throw new InvalidArgumentException('The entity need to be a user');
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
            'email' => $entity->getEmail(),
            'password' => $entity->getPassword(),
            'role'=> strtolower($shortClassName)
        ];
        /**
         * Create an array who registered all the specifics files linked to the type of the product
         */
        $date = new DateTime();
        $specificFields = [];
        /**
         * Set all the value to the specificsFields array to set them for add in db
         */
        if ($entity instanceof Customer) {
            $specificFields = [
                'deliveryAddress' => $entity->getDeliveryAddress(),
                'cart' => $entity->getCart(),
            ];
        } elseif ($entity instanceof Seller) {
            $specificFields = [
                'store' => $entity->getStore(),
                'commission' => $entity->getCommission(),
            ];
        } elseif ($entity instanceof Admin) {
            $specificFields = [
                'accessLevel' => $entity->getAccessLevel(),
                'lastConnection' => $date->format('Y-m-d'),
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
            $request = $this->db->prepare("INSERT INTO user ($columns) VALUES ($placeholders)");
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
        } catch (PDOException $e){
            die('The request to add user doesn\'t work correctly : ' . $e);
        }
        /**
         * Get the last id inserted in product table and return it
         */
       return (int) $this->db->lastInsertId();

    }

    /**
     * Update a user and do it in db
     *
     * @param object $entity
     * @return void
     */
    public function update(object $entity): void
    {
        if (!$entity instanceof User) {
            throw new InvalidArgumentException('The entity must be an instance of User');
        }
    
        // Récupération du type de classe
        $type = get_class($entity);
        $shortClassName = basename(str_replace('\\', '/', $type));
    
        // Champs communs pour tous les utilisateurs
        $commonFields = [
            'name' => $entity->getName(),
            'email' => $entity->getEmail(),
            'password' => $entity->getPassword(),
            'role' => strtolower($shortClassName),
        ];
    
        // Champs spécifiques selon le type d'utilisateur
        $specificFields = [];
    
        if ($entity instanceof Customer) {
            $specificFields = [
                'deliveryAddress' => $entity->getDeliveryAddress(),
                'cart' => $entity->getCart(),
            ];
        } elseif ($entity instanceof Seller) {
            $specificFields = [
                'store' => $entity->getStore(),
                'commission' => $entity->getCommission(),
            ];
        } elseif ($entity instanceof Admin) {
            $specificFields = [
                'accessLevel' => $entity->getAccessLevel(),
                // Utiliser la valeur existante ou une valeur par défaut
                'lastConnection' => $entity->getLastConnection() instanceof \DateTime
                    ? $entity->getLastConnection()
                    : new \DateTime(),
            ];
        }
    
        // Fusion des champs
        $fields = array_merge($commonFields, $specificFields);
    
        // Construction de la clause SET
        $setClause = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($fields)));
    
        try {
            // Préparation de la requête
            $request = $this->db->prepare("UPDATE user SET $setClause WHERE id = :id");
    
            // Liaison des valeurs
            foreach ($fields as $key => $value) {
                if ($value instanceof \DateTime) {
                    // Conversion DateTime en chaîne SQL
                    $value = $value->format('Y-m-d H:i:s');
                }
                $request->bindValue(":$key", $value); // bindValue plutôt que bindParam pour éviter les références directes
            }
    
            $request->bindValue(':id', $entity->getId(), PDO::PARAM_INT);
    
            // Exécution de la requête
            $request->execute();
        } catch (PDOException $e) {
            die('The request to update user doesn\'t work correctly: ' . $e->getMessage());
        }
    }
    
        /**
     * Function to delete 
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void{
    
        try {
            $request = $this->db->prepare('DELETE * FROM user WHERE id = :id');
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
        $query = 'SELECT * FROM user';
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
        $request->execute($params);

        $results = $request->fetchAll(PDO::FETCH_ASSOC);
        $users = [];

        foreach($results as $user){
            $products[] = UserFactory::createUser($user['role'], $user);
        }
        
        return $users;
    }

}