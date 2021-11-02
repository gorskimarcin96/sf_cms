<?php

namespace App\Utils\Mailer;

use App\Repository\PositionRepository;
use App\Utils\Crawler\Mem\Demotywatory;
use App\Utils\Crawler\Mem\Kwejk;
use App\Utils\Crawler\Quote\Biblijni;
use App\Utils\Crawler\Quote\CytatyInfo;
use App\Utils\File\FileManager;
use App\Utils\Style\CssManager;
use DateTime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;

class MailerFactory
{
    public const TEST_TYPE = 'test';
    public const APELINIA_TYPE = 'apelinia';

    public function __construct(
        private FileManager        $fileManager,
        private Kwejk              $kwejk,
        private Demotywatory       $demotywatory,
        private Biblijni           $biblijni,
        private CytatyInfo         $cytatyInfo,
        private PositionRepository $positionRepository,
        private CssManager         $cssManager,
    ) {
    }

    public function create(string $from, array $to, string $type): array
    {
        $email = (new TemplatedEmail())->from($from);

        switch ($type) {
            case self::TEST_TYPE:
                $email
                    ->priority(Email::PRIORITY_HIGH)
                    ->subject('Time for Symfony Mailer!')
                    ->text('Sending emails is fun again!')
                    ->htmlTemplate('emails/test.html.twig');
                break;
            case self::APELINIA_TYPE:
                $now = new DateTime();
                $firstApeliniaDay = new DateTime('2021-02-07');
                $this->fileManager->saveFile(file_get_contents($this->kwejk->getLinkToRandMem()), 'kwejk.jpg', true);
                $this->fileManager->saveFile(file_get_contents($this->demotywatory->getLinkToRandMem()), 'demotywator.jpg', true);
                $context = [
                    'gradient'    => $this->cssManager->randGradient(),
                    'days'        => $firstApeliniaDay->diff($now)->days,
                    'life_quote'  => $this->cytatyInfo->getRandQuote(),
                    'bible_quote' => $this->biblijni->getRandQuote(),
                ];

                if ($now->format('N') === "6") {
                    $context['position'] = $this->positionRepository->randOne();
                    $this->fileManager->saveFile($context['position']->getImage(), 'pozycja.png', true);
                    $email->embed($this->fileManager->openFile('pozycja.png', true), 'pozycja.png');
                }

                $email
                    ->priority(Email::PRIORITY_HIGH)
                    ->subject('Love letter ' . $now->format('Y-m-d'))
                    ->htmlTemplate('emails/apelinia.html.twig')
                    ->embed($this->fileManager->openFile('demotywator.jpg', true), 'demotywator.jpg')
                    ->embed($this->fileManager->openFile('kwejk.jpg', true), 'kwejk.jpg')
                    ->embed($this->fileManager->openFile('Odi.png', true), 'Odi.png')
                    ->context($context);
                break;
            default:
                throw new MailerWrongTypeException($type);
        }

        foreach ($to as $toEmail) {
            $emails[] = $email->to($toEmail);
        }

        return $emails ?? [];
    }
}
