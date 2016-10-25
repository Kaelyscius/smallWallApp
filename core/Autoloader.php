<?php

namespace Core;

class Autoloader
{

    /**
     * Inclue le fichier correspondant à notre classe
     * @param $class string Le nom de la classe à charger
     */
    public static function autoload($class)
    {
        if (strpos($class, __NAMESPACE__ . '\\') === 0) {

            $class = str_replace(__NAMESPACE__ . '\\', '', $class);
            $class = str_replace('\\', '/', $class);

            if (file_exists(__DIR__ . '/' . $class . '.php'))
                require __DIR__ . '/' . $class . '.php';
        }
    }

}
