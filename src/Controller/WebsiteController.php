<?php

namespace App\Controller;

use App\Entity\Interface\TranslationInterface as Locale;
use App\Factory\ContactMailer;
use App\Form\MailType;
use App\Repository\ArticleRepository;
use App\Repository\RealizationRepository;
use App\Repository\SliderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale}/')]
class WebsiteController extends AbstractController
{
    #[Route(name: 'homepage')]
    public function index(
        SliderRepository $sliderRepository,
        ArticleRepository $articleRepository,
        RealizationRepository $realizationRepository
    ): Response {
        return $this->render('website/homepage.html.twig', [
            'sliders' => $sliderRepository->findAll(),
            'articles' => $articleRepository->findAll(),
            'realizations' => $realizationRepository->findBy([], ['createdAt' => 'asc']),
        ]);
    }

    #[Route([Locale::POLISH => 'kontakt', Locale::ENGLISH => 'contact'], name: 'contact')]
    public function contact(
        Request $request,
        TranslatorInterface $translator,
        ContactMailer $contactMailer,
        MailerInterface $mailer,
    ): Response {
        $form = $this->createForm(MailType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            try {
                $data = $form->getData();

                if (5 === (int)$data['number']) {
                    $mailer->send($contactMailer->build($data['email'], $data['message']));

                    $this->addFlash('success', $translator->trans('The form has been sent.'));
                } else {
                    $this->addFlash('danger', $translator->trans('Math operation is not valid.'));
                }
            } catch (TransportExceptionInterface) {
                $this->addFlash('danger', $translator->trans('An error has occurred.'));
            }
        }

        return $this->render('website/contact.html.twig', ['form' => $form->createView()]);
    }

    #[Route([Locale::POLISH => 'o-mnie', Locale::ENGLISH => 'about-me'], name: 'about me')]
    public function aboutMe(Request $request): Response
    {
        return match ($request->getLocale()) {
            Locale::POLISH => $this->render('website/about-me.html.twig'),
            default => $this->render('website/not-access.html.twig'),
        };
    }

    #[Route('curriculum-vitae', name: 'curriculum vitae')]
    public function curriculumVitae(Request $request): Response
    {
        return $this->render('website/curriculum-vitae.html.twig', [
            'CVPath' => sprintf('upload/CV_%s.pdf', strtoupper($request->getLocale())),
        ]);
    }
}
