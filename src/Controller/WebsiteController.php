<?php

namespace App\Controller;

use App\Form\MailType;
use App\Repository\ArticleRepository;
use App\Repository\OfferRepository;
use App\Repository\RealizationRepository;
use App\Repository\SliderRepository;
use App\Tools\WebFeatures\Both\Counter\CounterManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class WebsiteController extends AbstractController
{
    public function __construct(CounterManager $cs)
    {
        $cs->entry();
    }

    #[Route('/', name: 'homepage')]
    public function index(
        Request               $request,
        SliderRepository      $sliderRepository,
        ArticleRepository     $articleRepository,
        OfferRepository       $offerRepository,
        RealizationRepository $realizationRepository
    ): Response {
        return $this->render('website/homepage.html.twig', [
            'sliders'      => $sliderRepository->findAll(),
            'articles'     => $articleRepository->findAll(),
            'offers'       => $offerRepository->findAll(),
            'realizations' => $realizationRepository->findAll(),
        ]);
    }

    #[Route(['pl' => 'kontakt', 'en' => 'contact'], name: 'contact')]
    public function contact(Request $request, TranslatorInterface $translator, MailerInterface $mailer): Response
    {
        $form = $this->createForm(MailType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            try {
                $data = $form->getData();

                $email = (new Email())
                    ->from($data['email'])
                    ->to($this->getParameter('app.email'))
                    ->subject('Formularz kontaktowy mgorski.dev')
                    ->html(
                        $this->renderView('website/email.html.twig', [
                            'email'       => $data['email'],
                            'description' => $data['message'],
                        ])
                    );
                $mailer->send($email);

                $this->addFlash('success', $translator->trans('The form has been sent.'));
            } catch (TransportExceptionInterface $exception) {
                $this->addFlash('danger', $translator->trans('An error has occurred.'));
            }
        }

        return $this->render('website/contact.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/curriculum-vitae', name: 'curriculum vitae')]
    public function curriculumVitae(): Response
    {
        return $this->render('website/curriculum-vitae.html.twig');
    }

    #[Route('/feature-not-implemented', name: 'feature not implemented')]
    public function featureNotImplemented(): Response
    {
        return $this->render('website/feature-not-implemented.html.twig');
    }
}
