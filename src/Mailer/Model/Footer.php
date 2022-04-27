<?php

namespace App\Mailer\Model;

class Footer
{
    public function __construct(private string $text, private string $image)
    {
    }

    public function render(): string
    {
        return '<div style="background: rgba(255,255,255, 0.3);border-radius: 10px; margin: 10px; padding: 10px;height:110px;">
            '.$this->getText().'
            '.$this->getImage().'
        </div>';
    }

    private function getText(): string
    {
        return $this->text;
    }

    public function getImage(): string
    {
        return '<img src="cid:'.$this->image.'" style="display: block; float: right; width: 120px;" alt="'.$this->image.'">';
    }
}
