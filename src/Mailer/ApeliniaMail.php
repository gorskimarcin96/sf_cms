<?php

namespace App\Mailer;

use App\Crawler\Mem\Demotywatory;
use App\Crawler\Mem\Kwejk;
use App\Crawler\Quote\Biblijni;
use App\Crawler\Quote\CytatyInfo;
use App\DBAL\Types\LocaleType;
use App\File\FileManager;
use App\Repository\DogJokeRepository;
use App\Repository\PositionRepository;
use App\String\CssManager;
use DateInterval;
use DateTime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class ApeliniaMail extends AbstractMailCreator
{
    public function __construct(
        Environment                $twig,
        private FileManager        $fileManager,
        private Kwejk              $kwejk,
        private Demotywatory       $demotywatory,
        private Biblijni           $biblijni,
        private CytatyInfo         $cytatyInfo,
        private PositionRepository $positionRepository,
        private DogJokeRepository  $dogJokeRepository,
        private CssManager         $cssManager,
        private RouterInterface    $router
    ) {
        $this->router->getContext()->setBaseUrl('https://mgorski.dev');

        parent::__construct(new MailBuilder(), new TemplatedEmail(), $fileManager, $twig);
    }

    public function create(): TemplatedEmail
    {
        $now = new DateTime();
        $style = 'style="background: rgba(255,255,255, 0.3);border-radius: 10px; margin: 10px; padding: 10px;"';
        $this->templatedEmail
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Love letter ' . $now->format('Y-m-d'));

        $this->setLayout('
            <div style="width: 700px;' . $this->cssManager->randGradient() . '">
                <div style="width: 700px;margin-top: 20px;">{{ body }}</div>
            </div>
        ');

        $this->append('
            <br>
            <div style="background: rgba(255,255,255, 0.3);border-radius: 10px; margin: 10px; padding: 10px;">
                <h1>❤💋❤ Love letter ❤💋❤</h1>
                <p>Jesteśmy razem {{ time }}! Ten wyjątkowy i niepowtarzalny dzień chce szczególnie uczcić!</p>
            </div>
        ', ['style' => $style, 'time' => $this->getApeliniaTime()]);

        if ($now->format('N') === "6") {
            $fileName = 'pozycja.png';

            $position = $this->positionRepository->randOne();
            $this->fileManager->saveFile($position->getImage(), $fileName, true);

            $this->append('
                <div {{ style|raw }}>
                    <h2>Pozycja tygodnia:</h2>
                    <h3>{{ position.title }}</h3>
                    <div style="text-align: center">
                        <img src="cid:pozycja.png" style="opacity: 0.9;" alt="pozycja">
                    </div>
                    <div><b>{{ position.firstSection|raw }}</b></div>
                    <div>{{ position.secondSection|raw }}</div>
                    <div style="text-align: center"><i>🔥🔥🔥 Czyli co byśmy dzisiaj robili, gdybyśmy już byli po ślubie 🔥🔥🔥</i></div>
                </div>
            ', ['style' => $style, 'position' => $position], [$fileName]);
        }

        $fileName = 'demotywator.jpg';
        $this->fileManager->saveFile(file_get_contents($this->demotywatory->getLinkToRandMem()), $fileName, true);
        $this->append('
             <div {{ style|raw }}>
                <h2>Motywator:</h2>
                <div style="text-align: center">
                    <img src="cid:demotywator.jpg" style="opacity: 0.9;" alt="demotywator">
                </div>
            </div>
        ', ['style' => $style], [$fileName]);

        $this->append('
            <div {{ style|raw }}>
                <h2>Cytat życia dnia:</h2>
                <div>{{ life_quote|raw }}</div>
            </div>
        ', ['style' => $style, 'life_quote' => $this->cytatyInfo->getRandQuote()]);

        $fileName = 'kwejk.jpg';
        $this->fileManager->saveFile(file_get_contents($this->kwejk->getLinkToRandMem()), $fileName, true);
        $this->append('
            <div {{ style|raw }}>
                <h2>Na wesoło:</h2>
                <div style="text-align: center">
                    <img src="cid:kwejk.jpg" style="opacity: 0.9;" alt="kwejk">
                </div>
            </div>
        ', ['style' => $style], [$fileName]);

        if (rand(0, 2)) {
            foreach ($this->dogJokeRepository->randSixNormal() as $key => $dogJoke) {
                $imgs[$key] = sprintf('dog_joke_%s.jpg', $key);
                $this->fileManager->saveFile(file_get_contents($dogJoke->getImage()), $imgs[$key], true);
            }

            $this->append('
                <div {{ style|raw }}>
                    <h2>Psie sucharki:</h2>
                    <div style="max-width: 100%;text-align: center;">
                        <table style="background:rgba(200,0,200,0.8);">
                            <tr>
                                <td style="background:rgba(255,255,255,0.4)"><img src="cid:dog_joke_0.jpg" style="opacity: 0.9;max-width: 320px;padding: 3px;" alt="dog_joke"></td>
                                <td style="background:rgba(255,255,255,0.4)"><img src="cid:dog_joke_1.jpg" style="opacity: 0.9;max-width: 320px;padding: 3px;" alt="dog_joke"></td>
                            </tr>
                            <tr>
                                <td style="background:rgba(255,255,255,0.4)"><img src="cid:dog_joke_2.jpg" style="opacity: 0.9;max-width: 320px;padding: 3px;" alt="dog_joke"></td>
                                <td style="background:rgba(255,255,255,0.4)"><img src="cid:dog_joke_3.jpg" style="opacity: 0.9;max-width: 320px;padding: 3px;" alt="dog_joke"></td>
                            </tr>
                            <tr>
                                <td style="background:rgba(255,255,255,0.4)"><img src="cid:dog_joke_4.jpg" style="opacity: 0.9;max-width: 320px;padding: 3px;" alt="dog_joke"></td>
                                <td style="background:rgba(255,255,255,0.4)"><img src="cid:dog_joke_5.jpg" style="opacity: 0.9;max-width: 320px;padding: 3px;" alt="dog_joke"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            ', ['style' => $style], $imgs ?? []);
        } else {
            foreach ($this->dogJokeRepository->randToCollage() as $key => $dogJoke) {
                $imgs[$key] = sprintf('dog_joke_%s.jpg', $key);
                $this->fileManager->saveFile(file_get_contents($dogJoke->getImage()), $imgs[$key], true);
            }

            $this->append('
                <div {{ style|raw }}>
                    <h2>Psie sucharki:</h2>
                    <div style="max-width: 100%;text-align: center;">
                        <table style="background:rgba(200,0,200,0.8);">
                            <tr>
                                <td style="background:rgba(255,255,255,0.4)" colspan="2"><img src="cid:dog_joke_0.jpg" style="opacity: 0.9;max-width: 100%;padding: 3px;" alt="dog_joke"></td>
                            </tr>
                            <tr>
                                <td style="background:rgba(255,255,255,0.4)" rowspan="2"><img src="cid:dog_joke_1.jpg" style="opacity: 0.9;max-width: 320px;padding: 3px;" alt="dog_joke"></td>
                                <td style="background:rgba(255,255,255,0.4)"><img src="cid:dog_joke_2.jpg" style="opacity: 0.9;max-width: 320px;padding: 3px;" alt="dog_joke"></td>
                            </tr>
                            <tr>
                                <td style="background:rgba(255,255,255,0.4)"><img src="cid:dog_joke_3.jpg" style="opacity: 0.9;max-width: 320px;padding: 3px;" alt="dog_joke"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            ', ['style' => $style], $imgs ?? []);
        }

        $this->append('
            <div {{ style|raw }}>
                <h2>Cytat z bibli:</h2>
                <div>{{ bible_quote|raw }}</div>
            </div>
        ', ['style' => $style, 'bible_quote' => $this->biblijni->getRandQuote()]);

        $this->append('
            <div style="background: rgba(255,255,255, 0.3);border-radius: 10px; margin: 10px; padding: 10px;height:110px;">
                Korospodencja Odik! Kliknij w ten <a href="{{ unsubscribe_url }}">link</a>, aby wypisać się z newslettera.
                <img src="cid:Odi.png" style="display: block; float: right; width: 120px;" alt="Odi">
            </div>
            <br>
        ', ['unsubscribe_url' => $this->router->generate('feature not implemented', ['_locale' => LocaleType::POLISH])], ['Odi.png']);

        return $this->templatedEmail->html($this->mailBuilder->renderHtml());
    }

    private function getApeliniaTime(): string
    {
        $now = new DateTime();
        $date = '';

        $firstApeliniaDay = new DateTime('2021-02-07');
        $years = $firstApeliniaDay->diff($now)->y;
        $firstApeliniaDay->add(new DateInterval(sprintf("P%sY", $firstApeliniaDay->diff($now)->y)));
        $months = $firstApeliniaDay->diff($now)->m;
        $firstApeliniaDay->add(new DateInterval(sprintf("P%sM", $firstApeliniaDay->diff($now)->m)));
        $days = $firstApeliniaDay->diff($now)->d;

        if ($years === 1) {
            $date .= $years . ' rok';
        } elseif ($years > 1) {
            $date .= $years . ' lat';
        }

        if ($months) {
            if ($years) {
                $date .= $days ? ', ' : ' i ';
            }

            if ($months === 1) {
                $date .= $months . ' miesiąc';
            } elseif (in_array($months, [2, 3, 4])) {
                $date .= $months . ' miesiące';
            } elseif ($months > 0) {
                $date .= $months . ' miesiący';
            }
        }

        if ($days) {
            if ($years || $months) {
                $date .= ' i ';
            }

            if ($days === 1) {
                $date .= $days . ' dzień';
            } else {
                $date .= $days . ' dni';
            }
        }

        return $date;
    }
}
