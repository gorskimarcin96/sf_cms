<?php

declare(strict_types=1);

namespace App\Entity\Traits;

trait TimeStampableTrait
{
    use CreatedAtTrait;
    use UpdatedAtTrait;
}
