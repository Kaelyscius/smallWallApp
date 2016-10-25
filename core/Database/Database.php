<?php
namespace Core\Database;

/**
 * Parent of database
 */
class Database
{
    protected static $_instance;

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {

            if (extension_loaded('pdo_mysql'))
                $className = '\Core\Database\MySqlDatabase';
            else
                $className = 'PostgreDatabase';

            self::$_instance = new $className();
        }

        return self::$_instance;
    }
}
