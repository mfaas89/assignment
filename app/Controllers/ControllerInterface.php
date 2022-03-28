<?php

namespace Controllers;

interface ControllerInterface
{
    public function response(int $status, array $data = [], string $message = ''): void;

    public function setInput(): void;

    public function getInput(string $name): mixed;
}
