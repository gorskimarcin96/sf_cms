<?php

namespace App\Tests;

use ReflectionClass;

trait Invoker
{
    public function invokeMethod(object $object, string $methodName, array $parameters = []): mixed
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    public function invokeMethodWithArrayArguments(object $object, string $methodName, array $parameters = [])
    {
        return call_user_func_array([$object, $methodName], $parameters);
    }
}