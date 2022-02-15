<?php

namespace App\Mailer;

use App\Crawler\Mem\Demotywatory;
use App\Crawler\Mem\Kwejk;
use App\Crawler\Quote\Biblijni;
use App\Crawler\Quote\CytatyInfo;
use App\File\FileManager;
use App\Repository\PositionRepository;
use App\String\CssManager;
use DateTime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
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
        private CssManager         $cssManager
    )
    {
        parent::__construct(new MailBuilder(), new TemplatedEmail(), $fileManager, $twig);
    }

    public function create(): TemplatedEmail
    {
        $now = new DateTime();
        $firstApeliniaDay = new DateTime('2021-02-07');
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
                <p>
                    Dzisiaj mija od dnia, którego się poznaliśmy dokładnie {{ days }} dni!
                    Ten wyjątkowy i niepowtarzalny dzień chce szczególnie uczcić!
                </p>
            </div>
        ', ['style' => $style, 'days' => $firstApeliniaDay->diff($now)->days]);

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
            ', ['style' => $style, 'position' => $position], $fileName);
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
        ', ['style' => $style], $fileName);

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
        ', ['style' => $style], $fileName);

        $this->append('
            <div {{ style|raw }}>
                <h2>Cytat z bibli:</h2>
                <div>{{ bible_quote|raw }}</div>
            </div>
        ', ['style' => $style, 'bible_quote' => $this->biblijni->getRandQuote()]);

        $this->append('
            <div style="background: rgba(255,255,255, 0.3);border-radius: 10px; margin: 10px; padding: 10px;height:110px;">
                Korospodencja Odik! Kliknij w ten <a href="#">link</a>, aby wypisać się z newslettera.
                <img src="cid:Odi.png" style="display: block; float: right; width: 120px;" alt="Odi">
            </div>
            <br>
        ', [], 'Odi.png');

        return $this->templatedEmail->html($this->mailBuilder->renderHtml());
    }
}
