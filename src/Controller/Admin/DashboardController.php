<?php

namespace App\Controller\Admin;

use App\EasyAdmin\UrlHelper;
use App\Entity\Article;
use App\Entity\Constant;
use App\Entity\MessengerMessages;
use App\Entity\Offer;
use App\Entity\Realization;
use App\Entity\Slider;
use App\Entity\Task;
use App\File\FileManager;
use App\File\LogReader;
use App\Form\CVType;
use App\Repository\ConstantRepository;
use App\WebFeatures\Backend\PdfManager;
use App\WebFeatures\Both\Counter\CounterChart;
use App\WebFeatures\Both\Counter\CounterStatistic;
use Cron\CronBundle\Entity\CronJob;
use Cron\CronBundle\Entity\CronReport;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private CounterStatistic   $counterStatistic,
        private CounterChart       $counterChart,
        private ConstantRepository $constantRepository,
        private PdfManager         $pdfManager,
        private FileManager        $fileManager,
        private RequestStack       $requestStack,
        private UrlHelper $url
    ) {
    }

    #[Route('/admin', name: 'easyadmin_dashboard')]
    public function index(): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->url->getTodoIndex());
        }

        return $this->render('easyadmin/dashboard.html.twig', [
            'charts'       => $this->counterChart->get(),
            'statics_data' => $this->counterStatistic->get(),
        ]);
    }

    #[Route('/admin/logs', name: 'easyadmin_logs', methods: ['GET', 'POST'])]
    public function logs(): Response
    {
        $files = $this->fileManager->getPathLogs();

        if ($this->requestStack->getCurrentRequest()->getMethod() === 'POST') {
            $formData = $this->requestStack->getCurrentRequest()->get('form');
            $from = $formData['from'] !== '' ? $formData['from'] - 1 : null;
            $to = $formData['to'] !== '' ? $formData['to'] - 1 : null;
            $logReader = new LogReader($formData['file']);
            $lines = $logReader->readLogs($from, $to);
        }

        return $this->render('easyadmin/logs.html.twig', [
            'startLineNumber' => isset($logReader) ? $logReader->getStartLine() : 0,
            'lines'           => $lines ?? null,
            'files'           => $this->prepareSelectInput($files),
            'formData'        => $formData ?? [],
        ]);
    }

    private function prepareSelectInput(array $files): array
    {
        foreach ($files as $file) {
            $explode = explode('/', $file);
            $data[$file] = end($explode) . ' (lines ' . (new LogReader($file))->getCountLines() . ')';
        }

        return $data ?? [];
    }

    #[Route('/admin/cv', name: 'easyadmin_cv', methods: 'GET')]
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
            } catch (Exception $exception) {
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
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-desktop')->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToRoute('Todo', 'fas fa-clipboard-list', 'easyadmin_todolist_index');
        yield MenuItem::linkToCrud(Article::class, 'fas fa-list', Article::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud(Offer::class, 'fas fa-newspaper', Offer::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud(Slider::class, 'fas fa-address-card', Slider::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud(Realization::class, 'fas fa-image', Realization::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud(Task::class, 'fas fa-tasks', Task::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud(CronJob::class, 'fa fa-list-alt', CronJob::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud(CronReport::class, 'fa fa-scroll', CronReport::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud(MessengerMessages::class, 'fas fa-train', MessengerMessages::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToUrl('Logs', 'fas fa-toilet-paper', $this->generateUrl('easyadmin_logs'))->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToUrl('Phpinfo', 'fab fa-php', $this->generateUrl('easyadmin_phpinfo'))->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToUrl('CV', 'fas fa-file', $this->generateUrl('easyadmin_cv'))->setPermission('ROLE_ADMIN');
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()->addWebpackEncoreEntry('backend');
    }
}
