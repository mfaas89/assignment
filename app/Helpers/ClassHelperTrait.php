<?php

namespace Helpers;

use DateTime;
use ReflectionException;
use ReflectionProperty;

trait ClassHelperTrait
{
    /**
     * @throws ReflectionException
     * @throws \Exception
     */
    public function __set(string $parameter, mixed $value): void
    {
        if (str_contains($parameter, '_')) {
            $parameter = lcfirst(
                str_replace(' ','', ucwords(
                        str_replace('_', ' ', $parameter)
                    )
                )
            );
        }

        $reflection = new ReflectionProperty($this, $parameter);

        if ($reflection->getType()?->getName() === 'DateTime' && is_string($value)) {
            $this->{$parameter} = new DateTime($value);
            return;
        }

        $this->{$parameter} = $value;
    }
}
