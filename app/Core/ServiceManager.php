<?php

namespace Core;

use ReflectionClass;

final class ServiceManager
{
    private static array $instances = [];

    /**
     * @param string $className
     * @param array $constructorArguments
     *
     * @return mixed
     */
    public static function getInstance(string $className, array $constructorArguments = []): mixed
    {
        return ServiceManager::$instances[$className]
            ?? ServiceManager::$instances[$className] = new $className(...$constructorArguments);
    }

    public static function setInstance(string $className, mixed $class): void
    {
        ServiceManager::$instances[$className] = $class;
    }
}
