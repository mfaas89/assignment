<?php

namespace Core;

class AutoLoader
{
    private static bool $isInitialized = false;

    /**
     * @return bool
     */
    public static function registerClasses(): bool
    {
        if (self::$isInitialized) {
            return false;
        }

        spl_autoload_register(function (string $class) {
            $file = '../' . str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
            if (file_exists($file)) {
                require $file;
                return true;
            }
            return false;
        });

        return self::$isInitialized = true;
    }

    /**
     * @return bool
     */
    public function register(): bool
    {
        return self::registerClasses();
    }
}
