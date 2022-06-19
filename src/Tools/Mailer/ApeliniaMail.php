<?php

namespace App\Tools\Mailer;

use App\DBAL\Types\LocaleType;
use App\Repository\DailyImageRepository;
use App\Repository\DogJokeRepository;
use App\Repository\PositionRepository;
use App\Tools\Crawler\Mem\Demotywatory;
use App\Tools\Crawler\Mem\Kwejk;
use App\Tools\Crawler\Quote\Biblijni;
use App\Tools\Crawler\Quote\CytatyInfo;
use App\Tools\File\FileManager;
use App\Tools\Image\Image;
use App\Tools\String\CssManager;
use App\Tools\String\Traits\TimeToPolishStringTrait;
use DateTime;
use ImagickException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class ApeliniaMail extends AbstractMailCreator
{
    use TimeToPolishStringTrait;

    private const FIRST_TIME = '2021-02-07';
    private const WEDDING_TIME = '2023-09-02 13:00';

    public function __construct(
        Environment $twig,
        private FileManager $fileManager,
        private Kwejk $kwejk,
        private Demotywatory $demotywatory,
        private Biblijni $biblijni,
        private CytatyInfo $cytatyInfo,
        private PositionRepository $positionRepository,
        private DogJokeRepository $dogJokeRepository,
        private DailyImageRepository $dailyImageRepository,
        private CssManager $cssManager,
        private RouterInterface $router
    ) {
        $this->router->getContext()->setBaseUrl('https://mgorski.dev');

        parent::__construct(
            new MailBuilder(),
            new TemplatedEmail(),
            $fileManager,
            $twig
        );
    }

    public function create(): TemplatedEmail
    {
        $collection = new SectionCollection();
        $now = DateTime::createFromFormat('U', time());

        $collection->addSection(
            '<h1>💜💋🧡 Love letter 🧡💋💜</h1>',
            '<p>Jesteśmy razem '.$this->getApeliniaFirstTime().'! Ten wyjątkowy i niepowtarzalny dzień chce szczególnie uczcić!</p>
            <p>'.((new DateTime(self::WEDDING_TIME))>$now?'Do ślubu zostało ':'Jesteśmy po ślubie ').$this->getApeliniaWeddingTime().'</p>'
        );

        try {
            $fileName = 'daily_image.jpg';
            if ((null !== $dailyImage = $this->dailyImageRepository->randOne())) {
                $this->fileManager->saveFile(
                    $dailyImage->getImage(),
                    $fileName,
                    true
                );
                $image = new Image($this->fileManager->getPath($fileName, true));

                if (random_int(0, 5) % 2 === 0) {
                    $image->pixel(random_int(1, 100) / 10);
                } elseif (random_int(0, 2) % 1 === 0) {
                    $randColor = Image::COLORS[array_rand(Image::COLORS)];
                    $image->changeColor(Image::COLORS[array_rand(Image::COLORS)]);
                }

                $textColor = isset($randColor) && in_array($randColor, [Image::COLOR_BLUE, Image::COLOR_RED, Image::COLOR_GREEN]) ? 'white' : 'black';
                $image->addString($this->getDayText((int)$now->format('N')), $textColor, 5);
                $image->addString('i ' . $dailyImage->getName(), $textColor, 6);
                $image->save();

                $collection->addSection(
                    '<h2>'.$dailyImage->getName().'</h2>',
                    null,
                    new \App\Tools\Mailer\Model\Image($this->fileManager->getPath($fileName, true), $fileName)
                );
            }
        } catch (ImagickException $exception) {
            //keep if Imagick is not install
        }

        if ($now->format('N') === "6") {
            $fileName = 'pozycja.png';
            if (null !== ($position = $this->positionRepository->randOne())) {
                $this->fileManager->saveFile(
                    $position->getImage(),
                    $fileName,
                    true
                );
                $collection->addSection(
                    '<h2>Pozycja tygodnia:</h2>',
                    '<h3>'.$position->getTitle().'</h3>
                            <div><b>'.$position->getFirstSection().'</b></div>
                            <div>'.$position->getSecondSection().'</div>'
                    .((new \DateTime(self::WEDDING_TIME)) > $now ? '<div style="text-align: center"><i>🔥🔥🔥 Czyli co byśmy dzisiaj robili, gdybyśmy już byli po ślubie 🔥🔥🔥</i></div>' : ''),
                    new \App\Tools\Mailer\Model\Image($this->fileManager->getPath($fileName, true), $fileName)
                );
            }
        } elseif ($now->format('N') === "7") {
            $collection->addSection(
                '<h2>Cytat z bibli:</h2>',
                '<div>'.$this->biblijni->getRandQuote().'</div>'
            );
        } else {
            $fileName = 'dog_joke.jpg';
            if ((null !== $dogJoke = $this->dogJokeRepository->randOne())) {
                $this->fileManager->saveFile(
                    $dogJoke->getImage(),
                    $fileName,
                    true
                );
                $collection->addSection(
                    '<h2>Psie sucharki:</h2>',
                    null,
                    new \App\Tools\Mailer\Model\Image($this->fileManager->getPath($fileName, true), $fileName)
                );
            }
        }

        $fileName = 'demotywator.jpg';
        $this->fileManager->saveFile(
            file_get_contents($this->demotywatory->getLinkToRandMem()),
            $fileName,
            true
        );
        $collection->addSection(
            '<h2>Motywator:</h2>',
            null,
            new \App\Tools\Mailer\Model\Image($this->fileManager->getPath($fileName, true), $fileName)
        )->addSection(
            '<h2>Cytat życia dnia:</h2>',
            '<div>'.$this->cytatyInfo->getRandQuote().'</div>'
        );

        $fileName = 'kwejk.jpg';
        $this->fileManager->saveFile(
            file_get_contents($this->kwejk->getLinkToRandMem()),
            $fileName,
            true
        );
        $collection->addSection(
            '<h2>Na wesoło:</h2>',
            null,
            new \App\Tools\Mailer\Model\Image($this->fileManager->getPath($fileName, true), $fileName)
        )->addFooter(
            'Korospodencja Odik! Kliknij w ten <a href="'.$this->router->generate(
                'feature not implemented',
                ['_locale' => LocaleType::POLISH]
            ).'">link</a>, aby wypisać się z newslettera.',
            new \App\Tools\Mailer\Model\Image($this->fileManager->getPath('Odi.png', true), 'Odi.png')
        );

        $templatedEmail = (new TemplatedEmail())
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Love letter '.$now->format('Y-m-d'))
            ->htmlTemplate('emails/apelinia.html.twig')
            ->context([
                'gradient' => $this->cssManager->randGradient(),
                'sections' => $collection
            ]);

        foreach ($collection->getImages() as $image) {
            $templatedEmail->embedFromPath($image->getPath(), $image->getFilename());
        }

        return $templatedEmail;
    }

    private function getApeliniaFirstTime(): string
    {
        return $this->getStringCalculateTime(new DateTime(self::FIRST_TIME));
    }

    private function getApeliniaWeddingTime(): string
    {
        return $this->getStringCalculateTime(new DateTime(self::WEDDING_TIME));
    }

    private function getDayText(int $day): string
    {
        return match ($day) {
            1 => 'Pogodnego poniedziałku!',
            2 => 'Miłego wtorku!',
            3 => 'Pracowitej środy!',
            4 => 'Radosnego czwartku!',
            5 => 'Luźnego piątku!',
            6 => 'Romantycznej soboty!',
            7 => 'Spokojnej niedzieli!',
            default => 'Miłego dnia'
        };
    }
}
