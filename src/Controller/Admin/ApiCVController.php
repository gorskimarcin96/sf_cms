<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Enum\CVEnum;
use App\Repository\CVRepository;
use App\Utils\PdfManager;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cv', name: 'admin_api_cv_')]
class ApiCVController extends AbstractController
{
    #[Route('/save/{preview}', name: 'preview', methods: 'POST')]
    public function prev(
        Request $request,
        string $preview,
        PdfManager $pdfManager,
        CVRepository $CVRepository,
        LoggerInterface $logger,
    ): JsonResponse {
        try {
            $data = $request->get('data');
            $view = $this->renderView('easyadmin/cv/show.html.twig', ['data' => $data]);
            $path = $this->getParameter('kernel.project_dir').'/public/upload/'.$preview.'.pdf';

            $pdfManager->createPdf($view, $path);
            $CVRepository->updateConstantDescriptionByEnum($data, CVEnum::from($preview));

            return new JsonResponse([], Response::HTTP_OK);
        } catch (\Throwable $throwable) {
            $logger->error($throwable::class.' '.$throwable->getMessage());

            return new JsonResponse([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/revert/{preview}', name: 'revert', methods: 'GET')]
    public function revert(string $preview, CVRepository $CVRepository): JsonResponse
    {
        return new JsonResponse(['data' => $CVRepository->findByEnum(CVEnum::from($preview))->getDescription()]);
    }
}
