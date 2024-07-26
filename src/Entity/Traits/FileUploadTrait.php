<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait FileUploadTrait
{
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $fileFn = null;

    public function getFileFn(): ?string
    {
        return $this->fileFn;
    }

    public function getUploadFileFn(): ?string
    {
        return $this->fileFn ? (self::getUploadDir().'/'.$this->fileFn) : null;
    }

    public function getFullFileFn(): ?string
    {
        return $this->fileFn ? (self::getBasePath().'/'.$this->fileFn) : null;
    }

    public function setFileFn(?string $file): self
    {
        $this->fileFn = $file;

        return $this;
    }

    public static function getClassName(): string
    {
        $ar = explode('\\', self::class);

        return array_pop($ar);
    }

    public static function getUploadDir(): string
    {
        return '/public/upload/'.self::getClassName();
    }

    public static function getBasePath(): string
    {
        return '/upload/'.self::getClassName();
    }
}
