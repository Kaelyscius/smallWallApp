<?php

use Core\Config;
use Core\Database\Database;

class App
{
    public $title = 'mon super site';

    private $dbInstance;
    private static $_instance;

    /**
     * Get only one instance of App.php
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }

        return self::$_instance;
    }

    /**
     * Autoloader settings
     */
    public static function load()
    {
        session_start();
        require ROOT . '/app/Autoloader.php';
        spl_autoload_register(array(App\Autoloader::class, 'autoload'));
        require ROOT . '/core/Autoloader.php';
        spl_autoload_register(array(Core\Autoloader::class, 'autoload'));
    }

    /**
     * Use Get Table as Factory Pattern
     * @param string
     * @return object
     */
    public function getTable($name)
    {
        $className = '\\App\\Table\\' . ucfirst($name) . 'Table';

        return new $className($this->getDb());
    }

    /**
     * use Get DB as Factory
     * Have only one instance of DB
     */
    public function getDb()
    {
        return Database::getInstance();
    }

}
