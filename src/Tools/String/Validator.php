<?php

namespace App\Tools\String;

class Validator
{
    public function contains(string $searchString, array $strings): bool
    {
        foreach ($strings as $string) {
            if (stripos($searchString, $string) !== false) {
                return true;
            }
        }

        return false;
    }
}
