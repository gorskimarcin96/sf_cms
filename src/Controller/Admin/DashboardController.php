<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Interface\TranslationInterface;
use App\Entity\Realization;
use App\Entity\Slider;
use App\Enum\CVEnum;
use App\Form\CVType;
use App\Repository\CVRepository;
use App\Utils\Counter\Chart;
use App\Utils\Counter\Stats;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Locale;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private readonly Stats $stats,
        private readonly Chart $chart,
        private readonly CVRepository $CVRepository,
    ) {
    }

    #[Route('/{_locale}/admin', name: 'admin_dashboard')]
    public function index(): Response
    {
        return $this->render('easyadmin/dashboard.html.twig', [
            'rows' => [
                [
                    'chart' => $this->chart->get(),
                    'stats' => $this->stats->get(),
                ],
            ],
        ]);
    }

    #[Route('/{_locale}/cv', name: 'admin_cv', defaults: ['_locale' => TranslationInterface::ENGLISH], methods: 'GET')]
    public function cv(string $_locale): Response
    {
        [$cv, $cvDraft, $assetPath] = match ($_locale) {
            TranslationInterface::POLISH => [CVEnum::CV_PL, CVEnum::CV_PL_DRAFT, 'upload/CV_PL_DRAFT.pdf'],
            TranslationInterface::ENGLISH => [CVEnum::CV_EN, CVEnum::CV_EN_DRAFT, 'upload/CV_EN_DRAFT.pdf'],
            default => throw new \LogicException('Locale is not valid.')
        };
        $form = $this->createForm(CVType::class, null, [
            'cv' => $this->CVRepository->findByEnum($cv)->getDescription(),
        ]);

        return $this->render('easyadmin/cv/index.html.twig', [
            'previewCVUrl' => $this->generateUrl('admin_api_cv_preview', ['preview' => $cv->value]),
            'previewCVDraftUrl' => $this->generateUrl('admin_api_cv_preview', ['preview' => $cvDraft->value]),
            'revertUrl' => $this->generateUrl('admin_api_cv_revert', ['preview' => $cv->value]),
            'assetPath' => $assetPath.'?'.random_bytes(10),
            'form' => $form->createView(),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setLocales([
                Locale::new(TranslationInterface::ENGLISH, '🇬🇧 English'),
                Locale::new(TranslationInterface::POLISH, '🇵🇱 Polski'),
            ])
            ->setTitle('<img src="/build/favicon/favicon.svg" alt="logo" width="50" class="bg-white p-1"> mgorski.dev')
            ->setFaviconPath('/build/favicon/favicon.svg');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Homepage', 'fa fa-home', $this->generateUrl('homepage'));
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-desktop');
        yield MenuItem::linkToCrud('Slider', 'fas fa-address-card', Slider::class);
        yield MenuItem::linkToCrud('Article', 'fas fa-list', Article::class);
        yield MenuItem::linkToCrud('Realization', 'fas fa-image', Realization::class);
        yield MenuItem::linkToUrl(
            'CV PL',
            'fas fa-file',
            $this->generateUrl('admin_cv', ['_locale' => TranslationInterface::POLISH])
        );
        yield MenuItem::linkToUrl(
            'CV EN',
            'fas fa-file',
            $this->generateUrl('admin_cv', ['_locale' => TranslationInterface::ENGLISH])
        );
        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out');
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()->addWebpackEncoreEntry('easyadmin');
    }
}
