<?php

namespace App\Mailer\Model;

class Section
{
    public function __construct(private string $title, private ?string $description = null, private ?string $image = null)
    {
    }

    public function render(): string
    {
        return '<div style="background: rgba(255,255,255, 0.3);border-radius: 10px; margin: 10px; padding: 10px;">
            '.$this->getTitle().'
            '.$this->getImage().'
            '.$this->getDescription().'
        </div>';
    }

    private function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getImage(): ?string
    {
        return $this->image ? '<div style="text-align: center">
            <img src="cid:'.$this->image.'" style="opacity: 0.9;max-width:99%;" alt="'.$this->image.'">
        </div>' : null;
    }
}
