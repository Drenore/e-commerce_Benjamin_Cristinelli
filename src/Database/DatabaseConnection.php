<?php 

namespace Flowup\ECommerce\Database;

use PDO;
use PDOException;
use Flowup\ECommerce\Config\Config;

class DatabaseConnection {

    /**
     * contain the instance of the database
     *
     * @var DatabaseConnection|null
     */
    private static ?DatabaseConnection $_instance = null;

    /**
     * Contain all variable define in Config classes for connect to bdd
     *
     * @var array
     */
    private array $config;
    /**
     * Class PDO contain all methods for use Db
     *
     * @var \PDO
     */
    private \PDO $connection;

    /**
     * Try connection on the db
     */
    private function __construct(){
        $this->config = Config::get();
        try {
            $this->connection = new \PDO("mysql:host=" .$this->config['host'].";dbname=".$this->config['dbname'].";charset=".$this->config['charset']."", $this->config['username'], $this->config['password']);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            throw("Error of connection : " . $e->getMessage());
        }
        
    }

      /**
       * Prevent duplication of instance
       *
       * @return void
       */
      private function __clone() {}
      public function __wakeup() {}

    /**
     * Set the method to initialize instance of the DB
     *
     * @return void
     */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new self();
        }

        return self::$_instance->connection;
    } 



}