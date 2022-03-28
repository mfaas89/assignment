<?php

namespace Core;

use Controllers\ControllerInterface;
use Database\PdoConnection;
use DirectoryIterator;

class App
{
    protected ?string $controllerName = null;
    protected ?string $methodName     = null;
    protected static array $config    = [];

    function __construct()
    {
        $this->createConfiguration();

        ServiceManager::setInstance(
            PdoConnection::class,
            new PdoConnection(
                static::$config['database']['host'],
                static::$config['database']['port'],
                static::$config['database']['username'],
                static::$config['database']['password'],
                static::$config['database']['database'],
            )
        );
        $url = $this->parseUrl();

        $this->configureRouteController($url);

        if (!$this->hasControllerAndMethod()) {
            header("HTTP/1.1 404 Not Found");
            return;
        }

        /** @var ControllerInterface $controller */
        $controller = new $this->controllerName();
        $controller->setInput();

        return $controller->{$this->methodName}();
    }

    protected function parseUrl(): array
    {
        $urlPath = htmlspecialchars(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        );

        if($urlPath) {
            return array_filter(
                explode('/', filter_var($urlPath), FILTER_SANITIZE_URL)
            );
        }

        return [];
    }

    public function createConfiguration(): void
    {
        /** @var DirectoryIterator $fileInfo */
        foreach (new DirectoryIterator('../config') as $fileInfo) {
            if ($fileInfo->getExtension() !== 'php') {
                continue;
            }

            $fileName = substr(
                $fileInfo->getFilename(),
                0,
                strrpos($fileInfo->getFilename(), '.')
            );
            static::$config[$fileName] = require($fileInfo->getRealPath());

            unset($fileName, $fileInfo);
        }
    }

    /**
     * @param array $url
     */
    protected function configureRouteController(array $url): void
    {
        $route = static::$config['routes'];

        foreach ($url as $paramKey => $routePath) {
            $key   = is_numeric($routePath) ? 'methods' : strtolower($routePath);
            $route = $route[$key] ?? null;

            if ($paramKey === 2) {
                $this->controllerName = $route['controller'] ?? null;
            }
        }

        $this->methodName = $route[strtolower($_SERVER['REQUEST_METHOD'])] ?? null;
    }

    private function hasControllerAndMethod(): bool
    {
        return class_exists($this->controllerName ?: '')
            && method_exists($this->controllerName, $this->methodName ?: '');
    }

    /**
     * @param string|null $configItem
     * @param mixed|null $defaultValue
     *
     * @return array
     */
    public static function getConfig(?string $configItem = null, mixed $defaultValue = null): array
    {
        if (!$configItem) {
            return static::$config;
        }

        $configItems = explode('.', $configItem);
        $config      = static::$config;

        foreach ($configItems as $configItem) {
            if (!isset($config[$configItem])) {
                $config = $defaultValue;
                break;
            }

            $config = $config[$configItem];
        }

        return $config;
    }
}
