<?php

namespace App\DBAL\Types;

use App\Tools\Crawler\Camasutra\Ofeminin;
use App\Tools\Crawler\Camasutra\ZdrowieGazeta;
use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class PositionType extends AbstractEnumType
{
    public static function getKey(string $className): string
    {
        return array_search($className, self::$choices);
    }

    protected static array $choices = [
        'O' => Ofeminin::class,
        'ZG' => ZdrowieGazeta::class,
    ];
}
