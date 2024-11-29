<?php 

namespace Flowup\ECommerce\Factory;

use InvalidArgumentException;
use Flowup\ECommerce\Entity\Product\PhysicalProduct;
use Flowup\ECommerce\Entity\Product\NumericalProduct;
use Flowup\ECommerce\Entity\Product\PerishableProduct;

class ProductFactory {
   
    public static function createProduct(string $type, array $params)
    {
        /**
         * 
         * Switch on type to know what kind of product we're building
         * 
         * @param $type string of type of product
         */
        switch($type){
            case "perishableproduct":
                return self::createPerishProduct($params);
            case "physicalproduct":
                return self::createPhysicalProduct($params);
            case "numericalproduct":
               return self::createNumericalProduct($params);
        }                     
    }
    /**
     * Create a Perishable product
     *
     * @param array $params
     * @return PerishableProduct
     * @throws exception if it's missing some arguments
     */
    private static function createPerishProduct(array $params): PerishableProduct
    {
        if (!isset($params['name'], $params['description'], $params['price'], $params['quantity'], $params['expirationDate'], $params['storageTemperature'])) {
            throw new InvalidArgumentException("Missing parameters for Perishable product");
        }
        return new PerishableProduct(
        !isset($params['id']) ? null : $params['id'],
         $params['name'], 
         $params['description'],
         $params['price'],
         $params['quantity'],
         $params['expirationDate'],
         $params['storageTemperature']
        );

    }

    /**
     * Create a numérical product
     *
     * @param array $params
     * @return NumericalProduct
     * @throws exception if it's missing some arguments
     */
    private static function createNumericalProduct(array $params): NumericalProduct
    {
        if(!isset($params['name'], $params['description'], $params['price'], $params['quantity'], $params['fileSize'], $params['fileFormat'],)){
            throw new InvalidArgumentException("Missing parameters for Numerical product");
        }
        return new NumericalProduct(
            !isset($params['id']) ? null : $params['id'],
            $params['name'], 
            $params['description'],
            $params['price'],
            $params['quantity'],
            $params['fileSize'],
            $params['fileFormat'],
        );
    }


    /**
     * Create a Physical product
     *
     * @param array $params
     * @return PhysicalProduct
     * @throws exception if it's missing some arguments
     */
    private static function createPhysicalProduct(array $params): PhysicalProduct
    {
        if(!isset($params['name'], $params['description'], $params['price'], $params['quantity'], $params['weight'], $params['length'], $params['width'], $params['height'])){
            throw new InvalidArgumentException("Missing parameters for Physical product");
        }
        return new PhysicalProduct(
            !isset($params['id']) ? null : $params['id'],
            $params['name'], 
            $params['description'],
            $params['price'],
            $params['quantity'],
            $params['weight'],
            $params['length'],
            $params['width'],
            $params['height'],
        );
    }
}