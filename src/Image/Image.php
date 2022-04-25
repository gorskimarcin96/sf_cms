<?php

namespace App\Image;

use Exception;
use Imagick;
use ImagickDraw;
use ImagickKernel;

class Image
{
    public const COLOR_GREY = 'grey';
    public const COLOR_CYAN = 'cyan';
    public const COLOR_BLUE = 'blue';
    public const COLOR_PURPLE = 'purple';
    public const COLOR_YELLOW = 'yellow';
    public const COLOR_RED = 'red';
    public const COLOR_GREEN = 'green';

    public const COLORS = [
        self::COLOR_GREY,
        self::COLOR_CYAN,
        self::COLOR_BLUE,
        self::COLOR_PURPLE,
        self::COLOR_YELLOW,
        self::COLOR_RED,
        self::COLOR_GREEN,
    ];

    private Imagick $imagick;

    public function __construct(string $pathToImage)
    {
        $this->imagick = new Imagick();

        $this->imagick->readImage($pathToImage);
    }

    public function show(): void
    {
        header("Content-Type: image/png");

        echo $this->imagick->getImageBlob();
        exit();
    }

    public function save(): void
    {
        $this->imagick->writeImage($this->imagick->getImageFilename());
    }

    public function addString(string $text, string $color, int $position): self
    {
        $draw = new ImagickDraw();

        $draw->setFillColor($color);
        $draw->setFont('Bookman-DemiItalic');
        $draw->setFontSize($this->imagick->getImageHeight() / 25);
        $draw->setTextAlignment(Imagick::ALIGN_CENTER);

        $x = $this->imagick->getImageWidth() / 2;
        $y = $this->imagick->getImageHeight() - ($this->imagick->getImageHeight() / $position);
        $this->imagick->annotateImage($draw, $x, $y, 0, $text);

        return $this;
    }

    public function pixel(float $strength): self
    {
        $kernel = ImagickKernel::fromMatrix([[-1, 0, -1], [0, 5, 0], [-1, 0, -1]]);
        $kernel->scale($strength, Imagick::NORMALIZE_KERNEL_VALUE);
        $kernel->addUnityKernel(1 - $strength);
        $this->imagick->filter($kernel);

        return $this;
    }

    public function changeColor($color = null): self
    {
        switch ($color) {
            case self::COLOR_GREY:
                $this->imagick->modulateImage(100, 0, 100);
                break;
            case self::COLOR_CYAN:
                $this->imagick->recolorImage([0]);
                break;
            case self::COLOR_BLUE:
                $this->imagick->recolorImage([0, 0, 0, 0]);
                break;
            case self::COLOR_PURPLE:
                $this->imagick->recolorImage([0, 1, 0, 0]);
                break;
            case self::COLOR_YELLOW:
                $this->imagick->recolorImage([0, 0, 0, 0]);
                $this->imagick->modulateImage(100, 100, 0);
                break;
            case self::COLOR_RED:
                $this->imagick->recolorImage([0]);
                $this->imagick->modulateImage(100, 100, 0);
                break;
            case self::COLOR_GREEN:
                $this->imagick->recolorImage([0, 1, 0, 0]);
                $this->imagick->modulateImage(100, 100, 0);
                break;
            default:
                throw new Exception(sprintf('Color %s is not implemented.', $color));
        }

        return $this;
    }
}
