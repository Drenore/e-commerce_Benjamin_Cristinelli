<?php 

namespace Flowup\ECommerce\Factory;

use Flowup\ECommerce\Entity\User\Admin;
use InvalidArgumentException;
use Flowup\ECommerce\Entity\User\Customer;
use Flowup\ECommerce\Entity\User\Seller;

class UserFactory {
   
    public static function createUser(string $type, array $params)
    {
        /**
         * 
         * Switch on type to know what kind of user we're building
         * 
         * @param $type string of type of user
         */
        switch($type){
            case "customer":
                return self::createCustomer($params);
            case "seller":
                return self::createSeller($params);
            case "admin":
               return self::createAdmin($params);
        }                     
    }
    /**
     * Create a Customer 
     *
     * @param array $params
     * @return Customer
     * @throws exception if it's missing some arguments
     */
    private static function createCustomer(array $params): Customer
    {
        if (!isset($params['name'], $params['email'], $params['password'], $params['deliveryAddress'], $params['cart'])) {
            throw new InvalidArgumentException("Missing parameters for Customer");
        }
        return new Customer(
        $params['id'] ? $params['id'] : null,
         $params['name'], 
         $params['email'],
         $params['password'],
         $params['deliveryAddress'],
         $params['cart'],
        );

    }

    /**
     * Create a seller 
     *
     * @param array $params
     * @return Seller
     * @throws exception if it's missing some arguments
     */
    private static function createSeller(array $params): Seller
    {
        if(!isset($params['name'], $params['email'], $params['password'], $params['store'], $params['commission'])){
            throw new InvalidArgumentException("Missing parameters for Seller");
        }
        return new Seller(
            $params['id'] ? $params['id'] : null,
            $params['name'], 
            $params['email'],
            $params['password'],
            $params['store'],
            $params['commission'],
        );
    }


    /**
     * Create a user Administrator
     *
     * @param array $params
     * @return Admin
     * @throws exception if it's missing some arguments
     */
    private static function createAdmin(array $params): Admin
    {
     
        if(!isset($params['name'], $params['email'], $params['password'], $params['accessLevel'], $params['lastConnection'])){
            throw new InvalidArgumentException("Missing parameters for Admin");
        }
        $lastConnection = is_string($params['lastConnection']) 
        ? \DateTime::createFromFormat('Y-m-d H:i:s', $params['lastConnection']) 
        : $params['lastConnection'];
        
        return new Admin(
            isset($params['id']) ? $params['id'] : null,
            $params['name'], 
            $params['email'],
            $params['password'],
            $params['accessLevel'],
            $lastConnection,
        );
    }
}