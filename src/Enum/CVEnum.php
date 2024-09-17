<?php

declare(strict_types=1);

namespace App\Enum;

enum CVEnum: string
{
    case CV_PL = 'CV_PL';
    case CV_PL_DRAFT = 'CV_PL_DRAFT';
    case CV_EN = 'CV_EN';
    case CV_EN_DRAFT = 'CV_EN_DRAFT';
}
