<?php

namespace App\Tools\String\Traits;

trait NamespaceHelperTrait
{
    public function getLastNameInNamespace(string $class): string
    {
        $explodeNamespace = explode('\\', $class);

        return is_array($explodeNamespace) ? end($explodeNamespace) : $class;
    }
}
