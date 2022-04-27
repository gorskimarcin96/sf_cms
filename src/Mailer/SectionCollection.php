<?php

namespace App\Mailer;

use App\Mailer\Model\Footer;
use App\Mailer\Model\Image;
use App\Mailer\Model\Section;
use Doctrine\Common\Collections\ArrayCollection;

class SectionCollection extends ArrayCollection
{
    /** @var Image[] */
    private array $images = [];

    public function addSection(
        string $title,
        ?string $description = null,
        ?Image $image = null
    ): self {
        $this->add(new Section($title, $description, $image?->getFilename()));

        if ($image) {
            $this->images[] = $image;
        }

        return $this;
    }

    public function addFooter(string $text, Image $image): SectionCollection
    {
        $this->add(new Footer($text, $image->getFilename()));

        $this->images[] = $image;

        return $this;
    }

    /** @return Image[] */
    public function getImages(): array
    {
        return $this->images;
    }
}
