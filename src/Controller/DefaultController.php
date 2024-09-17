<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Interface\TranslationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default')]
    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('homepage', ['_locale' => TranslationInterface::POLISH]);
    }

    #[Route('/phone-number', name: 'phone_number')]
    public function phoneNumber(string $appPhoneNumber): JsonResponse
    {
        return new JsonResponse(['phone_number' => $appPhoneNumber]);
    }
}
