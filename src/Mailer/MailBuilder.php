<?php

namespace App\Mailer;

class MailBuilder
{
    private string $layout = '{{ body }}';
    private array $elements = [];

    public function clearElements(): void
    {
        $this->elements = [];
    }

    public function setLayout(string $layout): MailBuilder
    {
        $this->layout = $layout;

        return $this;
    }

    public function append(string $html): MailBuilder
    {
        $this->elements[] = $html;

        return $this;
    }

    public function renderHtml(): string
    {
        return str_replace(['{{ body }}'], [implode('', $this->elements)], $this->layout);
    }
}
