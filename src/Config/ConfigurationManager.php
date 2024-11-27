<?php

namespace Flowup\ECommerce\Config;

class ConfigurationManager
{
    private static ?ConfigurationManager $_instance = null;
    private array $config = [];
    /**
     * Private contruct
     */
    private function __construct()
    {
        $this->config = [
            'VAT' => 0.20,
            'currency' => 'EUR',
            'baseShippingFee' => 5.0,
            'contactEmail' => 'contact@example.com',
        ];
    }

    /**
     * Private clone to prevent cloning instance
     */
    private function __clone() {}

    /**
     * Prevent wakeup function to work
     */
    public function __wakeup() {}
    /**
     * Start instance si not existing a time
     *
     * @return void
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new ConfigurationManager();
        }

        return self::$_instance;
    }

    /**
     * Charge la configuration à partir d'un tableau ou d'un fichier
     *
     * @param array|string $source Configuration sous forme de tableau ou chemin vers un fichier
     * @throws \InvalidArgumentException Si le format est incorrect
     */
    public function loadConfig($source): void
    {
        if (is_array($source)) {
            $this->config = array_merge($this->config, $source);
        } elseif (is_string($source) && file_exists($source)) {
            $fileConfig = include $source;
            if (!is_array($fileConfig)) {
                throw new \InvalidArgumentException("The file of configuration need to be an array");
            }
            $this->config = array_merge($this->config, $fileConfig);
        } else {
            throw new \InvalidArgumentException("Source of configuration is invalid.");
        }
    }

    /**
     * Get the value of a parameter
     *
     * @param string $key Name of the parameter
     * @return mixed Value of the parameter
     * @throws \InvalidArgumentException if the parameter doesn't exist
     */
    public function get(string $key)
    {
        if (!isset($this->config[$key])) {
            throw new \InvalidArgumentException("The parameter '$key' doesn't exist.");
        }
        return $this->config[$key];
    }

    /**
     * Define the value of a parameter with validation about it 
     *
     * @param string $key Name of the parameter
     * @param mixed $value Value of the parameter
     * @throws \InvalidArgumentException if validation not working
     */
    public function set(string $key, $value): void
    {
        switch ($key) {
            case 'VAT':
                if (!is_numeric($value) || $value < 0 || $value > 100) {
                    throw new \InvalidArgumentException("");
                }
                break;
            case 'currency':
                if (!is_string($value) || strlen($value) !== 3) {
                    throw new \InvalidArgumentException("Devise need to be a name in 3 letter ex 'EUR' ");
                }
                break;
            case 'baseShippingFee':
                if (!is_numeric($value) || $value < 0) {
                    throw new \InvalidArgumentException("Delivery base price need to be at minimum 0");
                }
                break;
            case 'contactEmail':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    throw new \InvalidArgumentException("Email isn't valide.");
                }
                break;
            default:
                throw new \InvalidArgumentException("Parameter '$key' isn't recognize.");
        }

        $this->config[$key] = $value;
    }

    /**
     * Return all the configuration
     *
     * @return array Associative array of the configuration
     */
    public function getAll(): array
    {
        return $this->config;
    }
}
