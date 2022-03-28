<?php

namespace Helpers;

trait StringHelperTrait
{
    /**
     * @param string $parameter
     *
     * @return string
     */
    public function toCamelCase(string $parameter): string
    {
        return lcfirst(
            str_replace(' ','', ucwords(
                    str_replace('_', ' ', $parameter)
                )
            )
        );
    }

    /**
     * @param $parameter
     *
     * @return string
     */
    public function camelCaseToUnderScore($parameter): string
    {
        $parameter = lcfirst($parameter);
        $parameter = preg_replace("/[A-Z]/", '_' . '$0', $parameter);

        return strtolower($parameter);
    }
}
