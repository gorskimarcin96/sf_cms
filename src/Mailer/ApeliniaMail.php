<?php

namespace App\Mailer;

use App\Crawler\Mem\Demotywatory;
use App\Crawler\Mem\Kwejk;
use App\Crawler\Quote\Biblijni;
use App\Crawler\Quote\CytatyInfo;
use App\DBAL\Types\LocaleType;
use App\File\FileManager;
use App\Image\Image;
use App\Repository\DailyImageRepository;
use App\Repository\DogJokeRepository;
use App\Repository\PositionRepository;
use App\String\CssManager;
use App\String\Traits\TimeToPolishStringTrait;
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
        $now = DateTime::createFromFormat('U', time());
        $defaultStyle = 'style="background: rgba(255,255,255, 0.3);border-radius: 10px; margin: 10px; padding: 10px;"';
        $imageStyle = 'style="opacity: 0.9;max-width:99%;"';
        $this->templatedEmail
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Love letter '.$now->format('Y-m-d'));

        $this->clearElements();
        $this->setLayout('
            <div style="width: 700px;'.$this->cssManager->randGradient().'">
                <div style="width: 700px;margin-top: 20px;">{{ body }}</div>
            </div>
        ');

        $this->append(
            '
            <br>
            <div style="background: rgba(255,255,255, 0.3);border-radius: 10px; margin: 10px; padding: 10px;">
                <h1>💜💋🧡 Love letter 🧡💋💜</h1>
                <p>Jesteśmy razem {{ firstTimeFormat }}! Ten wyjątkowy i niepowtarzalny dzień chce szczególnie uczcić!</p>
                <p>{{ weddingTime > "now" ? "Do ślubu zostało" : "Jesteśmy po ślubie" }} {{ weddingTimeFormat }}.</p>
            </div>',
            [
                'style'             => $defaultStyle,
                'firstTimeFormat'   => $this->getApeliniaFirstTime(),
                'weddingTime'       => new DateTime(self::WEDDING_TIME),
                'weddingTimeFormat' => $this->getApeliniaWeddingTime(),
            ]
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

                $textColor = isset($randColor)
                    && in_array($randColor, [Image::COLOR_BLUE, Image::COLOR_RED, Image::COLOR_GREEN])
                    ? 'white' : 'black';

                $image->addString($this->getDayText((int)$now->format('N')), $textColor, 5);
                $image->addString('i ' . $dailyImage->getName(), $textColor, 6);
                $image->save();

                $this->append(
                    '
                    <div {{ defaultStyle|raw }}>
                        <h2>{{ dailyImage.name }}</h2>
                        <div style="text-align: center">
                            <img src="cid:daily_image.jpg" {{ imageStyle|raw }} alt="daily_image">
                        </div>
                    </div>
                    ',
                    [
                        'defaultStyle' => $defaultStyle,
                        'imageStyle'   => $imageStyle,
                        'dailyImage'   => $dailyImage,
                    ],
                    [$fileName]
                );
            }
        } catch (ImagickException $exception) {
            //keep if Imagick is not install
            dump($exception);
        }

        if ($now->format('N') === "6") {
            $fileName = 'pozycja.png';
            if (null !== ($position = $this->positionRepository->randOne())) {
                $this->fileManager->saveFile(
                    $position->getImage(),
                    $fileName,
                    true
                );
                $this->append(
                    '
                        <div {{ defaultStyle|raw }}>
                            <h2>Pozycja tygodnia:</h2>
                            <h3>{{ position.title }}</h3>
                            <div style="text-align: center">
                                <img src="cid:pozycja.png" {{ imageStyle|raw }} alt="pozycja">
                            </div>
                            <div><b>{{ position.firstSection|raw }}</b></div>
                            <div>{{ position.secondSection|raw }}</div>
                            {% if weddingTime > "now" %}
                                <div style="text-align: center"><i>🔥🔥🔥 Czyli co byśmy dzisiaj robili, gdybyśmy już byli po ślubie 🔥🔥🔥</i></div>
                            {% endif %}
                        </div>
                    ',
                    [
                        'defaultStyle' => $defaultStyle,
                        'imageStyle'   => $imageStyle,
                        'position'     => $position,
                        'weddingTime'  => new DateTime(self::WEDDING_TIME),
                    ],
                    [$fileName]
                );
            }
        } elseif ($now->format('N') === "7") {
            $this->append(
                '
                <div {{ defaultStyle|raw }}>
                    <h2>Cytat z bibli:</h2>
                    <div>{{ bible_quote|raw }}</div>
                </div>
                ',
                [
                    'defaultStyle' => $defaultStyle,
                    'bible_quote'  => $this->biblijni->getRandQuote(),
                ]
            );
        } else {
            $fileName = 'dog_joke.jpg';
            if ((null !== $dogJoke = $this->dogJokeRepository->randOne())) {
                $this->fileManager->saveFile(
                    $dogJoke->getImage(),
                    $fileName,
                    true
                );
                $this->append(
                    '
                <div {{ defaultStyle|raw }}>
                    <h2>Psie sucharki:</h2>
                    <div style="text-align: center">
                        <img src="cid:dog_joke.jpg" {{ imageStyle|raw }} alt="dog_joke">
                    </div>
                </div>
            ',
                    [
                        'defaultStyle' => $defaultStyle,
                        'imageStyle'   => $imageStyle,
                    ],
                    [$fileName]
                );
            }
        }

        $fileName = 'demotywator.jpg';
        $this->fileManager->saveFile(
            file_get_contents($this->demotywatory->getLinkToRandMem()),
            $fileName,
            true
        );
        $this->append(
            '
             <div {{ defaultStyle|raw }}>
                <h2>Motywator:</h2>
                <div style="text-align: center">
                    <img src="cid:demotywator.jpg" style="opacity: 0.9;" alt="demotywator">
                </div>
            </div>
        ',
            ['defaultStyle' => $defaultStyle],
            [$fileName]
        );

        $this->append(
            '
            <div {{ defaultStyle|raw }}>
                <h2>Cytat życia dnia:</h2>
                <div>{{ life_quote|raw }}</div>
            </div>
        ',
            [
                'defaultStyle' => $defaultStyle,
                'life_quote'   => $this->cytatyInfo->getRandQuote(),
            ]
        );

        $fileName = 'kwejk.jpg';
        $this->fileManager->saveFile(
            file_get_contents($this->kwejk->getLinkToRandMem()),
            $fileName,
            true
        );
        $this->append(
            '
            <div {{ defaultStyle|raw }}>
                <h2>Na wesoło:</h2>
                <div style="text-align: center">
                    <img src="cid:kwejk.jpg" style="opacity: 0.9;" alt="kwejk">
                </div>
            </div>
        ',
            ['defaultStyle' => $defaultStyle],
            [$fileName]
        );

        $this->append(
            '
            <div style="background: rgba(255,255,255, 0.3);border-radius: 10px; margin: 10px; padding: 10px;height:110px;">
                Korospodencja Odik! Kliknij w ten <a href="{{ unsubscribe_url }}">link</a>, aby wypisać się z newslettera.
                <img src="cid:Odi.png" style="display: block; float: right; width: 120px;" alt="Odi">
            </div>
            <br>
        ',
            [
            'unsubscribe_url' => $this->router->generate(
                'feature not implemented',
                ['_locale' => LocaleType::POLISH]
            ),
        ],
            ['Odi.png']
        );

        return $this->templatedEmail->html($this->mailBuilder->renderHtml());
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
