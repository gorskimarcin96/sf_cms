<?php

namespace App\Tools\String;

class StringConverter
{
    public function __construct(private string $string)
    {
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return $this->string;
    }

    public function trim(): self
    {
        $this->string = trim($this->string);

        return $this;
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

    public function removeHtmlTag(string $htmlTag, bool $removeContent = true): self
    {
        if ($removeContent) {
            $this->string = preg_replace(sprintf('#<%s(.*?)>(.*?)</%s>#is', $htmlTag, $htmlTag), '', $this->string);
        } else {
            $tags = $this->getHtmlTags();

            if (($key = array_search($htmlTag, $tags)) !== false) {
                unset($tags[$key]);
            }

            $this->string = strip_tags($this->string, $tags);
        }

        return $this;
    }

    public function removeHtmlAttr(string $string): self
    {
        $this->string = preg_replace('/(<[^>]+) '.$string.'=".*?"/i', '$1', $this->string);

        return $this;
    }

    public function mbConvertEncoding(string $from, string $to): self
    {
        $this->string = mb_convert_encoding($this->string, $to, $from);

        return $this;
    }

    public function remove(string|array $removeString): self
    {
        $this->string = str_replace($removeString, '', $this->string);

        return $this;
    }

    public function removeToStart(string $string): self
    {
        $this->string = substr($this->string, strpos($this->string, $string));

        return $this;
    }

    public function removeStartEnd(string $start, string $end): self
    {
        while (str_contains($this->string, $start) && str_contains($this->string, $end)) {
            $searchString = substr($this->string, strpos($this->string, $start), strpos($this->string, $end));
            $this->string = str_replace($searchString, '', $this->string);
        }

        return $this;
    }

    private function getHtmlTags(): array
    {
        return [
            // basic
            '!DOCTYPE', 'html', 'title', 'body',
            'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
            'p', 'br', 'hr',
            // formatting
            'acronym', 'abbr', 'address', 'b', 'bdi', 'bdo', 'big',
            'blockquote', 'center', 'cite', 'code', 'del', 'dfn', 'em',
            'font', 'i', 'ins', 'kbd', 'mark', 'meter', 'pre', 'progress',
            'q', 'rp', 'rt', 'ruby', 's', 'samp', 'small', 'strike', 'strong',
            'sub', 'sup', 'time', 'tt', 'u', 'var', 'wbr',
            // forms and input
            'form', 'input', 'textarea', 'button', 'select', 'optgroup', 'option',
            'label', 'fieldset', 'legend', 'datalist', 'keygen', 'output',
            // frames
            'frame', 'frameset', 'noframes', 'iframe',
            // images
            'img', 'map', 'area', 'canvas', 'figcaption', 'figure',
            // audio and video
            'audio', 'source', 'track', 'video',
            // links
            'a', 'link', 'nav',
            // lists
            'ul', 'ol', 'li', 'dir', 'dl', 'dt', 'dd', 'menu', 'menuitem',
            // tables
            'table', 'caption', 'th', 'tr', 'td', 'thead', 'tbody', 'tfoot', 'col', 'colgroup',
            // styles and semantics
            'style', 'div', 'span', 'header', 'footer', 'main', 'section', 'article',
            'aside', 'details', 'dialog', 'summary',
            // meta info
            'head', 'meta', 'base', 'basefont',
            // programming
            'script', 'noscript', 'applet', 'embed', 'object', 'param'
        ];
    }

    public function ucfirst(string $encoding = 'UTF-8'): self
    {
        $this->string = mb_strtoupper(mb_substr($this->string, 0, 1, $encoding), $encoding)
            .mb_substr($this->string, 1, null, $encoding);

        return $this;
    }
}
