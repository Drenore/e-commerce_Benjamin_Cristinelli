<?php

namespace Flowup\ECommerce\Config;

class Config {
    public static function get(): array{
        return [
            'host' => 'localhost',
            'dbname' => 'ecommerce',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8'
        ];
    }
}

?>