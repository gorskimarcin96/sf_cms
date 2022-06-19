<?php

namespace App\Tools\String;

class CssManager
{
    public function randGradient(): string
    {
        return 'background: linear-gradient(' . rand(0, 360) . 'deg, ' . $this->randColor() . ' 0%, ' . $this->randColor() . ' ' . rand(25, 75) . '%, ' . $this->randColor() . ' 100%);';
    }

    private function randColor(): string
    {
        return 'rgba(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ',1)';
    }
}
