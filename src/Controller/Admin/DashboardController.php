<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Constant;
use App\Entity\Date;
use App\Entity\MessengerMessages;
use App\Entity\Offer;
use App\Entity\Realization;
use App\Entity\Slider;
use App\Entity\Task;
use App\Form\CVType;
use App\Repository\ConstantRepository;
use App\Utils\Date\DateManager;
use App\Utils\Features\Backend\ChartCounter;
use App\Utils\Features\Backend\PdfManager;
use App\Utils\Features\Both\Counter\CounterChart;
use App\Utils\Features\Both\Counter\CounterStatistic;
use App\Utils\Features\CounterManager;
use Cron\CronBundle\Entity\CronJob;
use Cron\CronBundle\Entity\CronReport;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private CounterStatistic   $counterStatistic,
        private CounterChart       $counterChart,
        private ConstantRepository $constantRepository,
        private PdfManager         $pdfManager
    ) {
    }

    #[Route('/admin', name: 'easyadmin_dashboard')]
    public function index(): Response
    {
        return $this->render('easyadmin/dashboard.html.twig', [
            'charts'       => $this->counterChart->get(),
            'statics_data' => $this->counterStatistic->get(),
        ]);
    }

    #[Route('/admin/cv', name: 'easyadmin_cv', methods:'get')]
    public function cv(): Response
    {
        $form = $this->createForm(CVType::class, null, [
            'cv' => $this->constantRepository->findCV()->getDescription(),
        ]);

        return $this->render('easyadmin/cv/index.html.twig', [
            'CV'       => Constant::CV,
            'CV_DRAFT' => Constant::CV_DRAFT,
            'form'     => $form->createView(),
        ]);
    }

    #[Route('/admin/cv/save/{preview}', name: 'easyadmin_cv_preview', methods: 'POST')]
    public function prev(Request $request, string $preview): JsonResponse
    {
        $response['success'] = false;

        if (in_array($preview, [Constant::CV, Constant::CV_DRAFT], true)) {
            try {
                $data = $request->get('data');

                $view = $this->renderView('easyadmin/cv/show.html.twig', ['data' => $data]);
                $path = $this->getParameter('kernel.project_dir') . '/public/upload/' . $preview . '.pdf';

                $this->pdfManager->createPdf($view, $path);
                $this->constantRepository->updateConstantDescriptionByTitle($preview, $data);

                $response['success'] = true;
            } catch (\Exception $exception) {
                $response = ['success' => false, 'error' => $exception->getMessage()];
            }
        }

        return new JsonResponse($response);
    }

    #[Route('/admin/cv/revert', name: 'easyadmin_cv_revert', methods: 'GET')]
    public function revert(): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'data'    => $this->constantRepository->findCV(),
        ]);
    }

    #[Route('/admin/phpinfo', name: 'easyadmin_phpinfo', methods: 'GET')]
    public function phpinfo(): Response
    {
        ob_start();
        phpinfo();
        $phpInfo = ob_get_contents();
        ob_get_clean();

        return $this->render('easyadmin/content.html.twig', [
            'data' => $phpInfo,
        ]);
    }

    public function configureMenuItems(): iterable
    {
        //https://fontawesome.com/v5.15/icons?d=gallery&p=2&m=free
        yield MenuItem::linkToUrl('Homepage', 'fa fa-home', $this->generateUrl('homepage'));
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-desktop');
        yield MenuItem::linkToCrud(Article::class, 'fas fa-list', Article::class);
        yield MenuItem::linkToCrud(Offer::class, 'fas fa-newspaper', Offer::class);
        yield MenuItem::linkToCrud(Slider::class, 'fas fa-address-card', Slider::class);
        yield MenuItem::linkToCrud(Realization::class, 'fas fa-image', Realization::class);
        yield MenuItem::linkToCrud(Task::class, 'fas fa-tasks', Task::class);
        yield MenuItem::linkToCrud(CronJob::class, 'fa fa-list-alt', CronJob::class);
        yield MenuItem::linkToCrud(CronReport::class, 'fa fa-scroll', CronReport::class);
        yield MenuItem::linkToCrud(MessengerMessages::class, 'fas fa-train', MessengerMessages::class);
        yield MenuItem::linkToUrl('Phpinfo', 'fab fa-php', $this->generateUrl('easyadmin_phpinfo'));
        yield MenuItem::linkToUrl('CV', 'fas fa-file', $this->generateUrl('easyadmin_cv'));
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()->addWebpackEncoreEntry('backend');
    }
}
