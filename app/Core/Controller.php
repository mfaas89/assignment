<?php

namespace Core;

use Controllers\ControllerInterface;
use DateTime;
use Exception;
use ReflectionException;
use ReflectionProperty;

abstract class controller implements ControllerInterface
{
    protected array          $params;
    protected ServiceManager $serviceManager;

    public function __construct()
    {
        $this->serviceManager = new ServiceManager();
    }

    public function setInput(): void
    {
        $this->params = $_REQUEST ?: json_decode(file_get_contents('php://input'), true) ?: [];

        foreach ($this->params as $param => $value) {
            $this->params[$param] = $this->sanitizeInput($value);
        }

        if (preg_match('!\d+!', $_SERVER['REQUEST_URI'], $matches)) {
            $this->params['id'] = (int) current($matches);
        }
    }

    /**
     * @param string $name
     * @param mixed|null $defaultValue
     * @return mixed
     */
    public function getInput(string $name, mixed $defaultValue = null): mixed
    {
        return $this->params[$name] ?? $defaultValue;
    }

    /**
     * @param int $status
     * @param array $data
     * @param string $message
     * @return void
     */
    final public function response(int $status, array $data = [], string $message = ''): void
    {
        header('HTTP/1.1 ' . $status);
        header('Content-Type:application/json');

        $response['data']                = $data;
        $message && $response['message'] = $message;

        echo json_encode($response);
    }

    final public function downloadResponse($file)
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        unset($file);
    }

    /**
     * @param mixed $value
     *
     * @return mixed|string
     */
    private function sanitizeInput(mixed $value): mixed
    {
        return match (true) {
            is_string($value) => htmlspecialchars($value, ENT_QUOTES),
            default           => $value,
        };
    }

    /**
     * @param string $className
     * @param string $parameter
     * @param mixed $value
     *
     * @return bool
     *
     * @throws ReflectionException
     * @throws Exception If DateTime is not a correct format
     */
    public function validateDataAgainstModel(string $className, string $parameter, mixed $value): bool
    {
        $reflection = new ReflectionProperty($className, $parameter);

        if ($reflection->getType()?->getName() === 'DateTime' && is_string($value)) {
            new DateTime($value);
            return true;
        }

        return $reflection->getType()?->getName() === gettype($value);
    }
}
