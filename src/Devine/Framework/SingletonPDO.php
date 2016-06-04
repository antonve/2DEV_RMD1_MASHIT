<?php

// SingletonPDO.php - Singleton for PDO connection
// By Anton Van Eechaute

namespace Devine\Framework;

use PDO;

class SingletonPDO
{
    /**
     * @var array  
     */
    private static $config;

    /**
     * @var SingletonPDO  
     */
    private static $instance;

    /**
     * Get the PDO instance, create it if it doesn't exist yet
     * @return PDO
     * @throws \Exception  
     */
    public static function getInstance()
    {
       if (isset(self::$config)) {
           if (!isset(self::$instance)) {
               try {
                   self::$instance = new \PDO('mysql:host=' . self::$config['host'] . ';dbname=' . self::$config['database'], self::$config['username'], self::$config['password']);
                   self::$instance->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
               }
               catch (PDOException $e) {
                   throw new \Exception('Connecting to database failed');
               }
           }
           
           return self::$instance;
       } else {
           throw new \Exception('Missing config info, can\'t instantiate PDO object');
       }
    }

    /**
     * Set the database configuration
     * @param type $config  
     */
    public static function setConfig($config)
    {
        self::$config = $config;
    }
}
