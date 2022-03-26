<?php

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class LocaleType extends AbstractEnumType
{
    public const POLISH = 'pl';
    public const ENGLISH = 'en';

    protected static array $choices = [
        self::POLISH => 'Polish',
        self::ENGLISH => 'English',
    ];
}
