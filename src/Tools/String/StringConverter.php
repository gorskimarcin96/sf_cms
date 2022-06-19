<?php

namespace App\Tools\String;

class StringConverter
{
    public function __construct(private string $string)
    {
    }

    public function __toString(): string
    {
        return $this->getString();
    }

    public function getString(): string
    {
        return $this->string;
    }

    public function removeMultilines(): self
    {
        $this->string = str_replace(["\n", "\r"], '', $this->string);

        return $this;
    }

    public function removeMultiSpaces(): self
    {
        $this->string = preg_replace('/\s+/', ' ', $this->string);

        return $this;
    }

    public function removeScriptTag(): self
    {
        $this->removeHtmlTag('script');

        return $this;
    }

    public function removeHtmlTag(string $htmlTag): self
    {
        $this->string = preg_replace(sprintf('#<%s(.*?)>(.*?)</%s>#is', $htmlTag, $htmlTag), '', $this->string);

        return $this;
    }

    public function trim(): self
    {
        $this->string = trim($this->string);

        return $this;
    }
}
