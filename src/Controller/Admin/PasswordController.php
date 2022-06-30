<?php

namespace App\Controller\Admin;

use App\Repository\PasswordRepository;
use App\Security\EncryptionManager;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PasswordController extends AbstractController
{
    #[Route('/password', name: 'password', methods: ['POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function index(
        Request $request,
        PasswordRepository $passwordRepository,
        EncryptionManager $encryptionManager
    ): Response {
        try {
            $pin = (int)$request->get('pin');
            $password = $passwordRepository->find($request->get('id')) ?? throw new EntityNotFoundException();
            $password->setPin($pin);
            $encodePassword = $encryptionManager->decrypt($password->getPassword());

            if ($password->getUsePin() && (strlen($pin) < 4 || !str_starts_with($encodePassword, $pin))) {
                return new JsonResponse(['error' => 'Pin is invalid.'], Response::HTTP_BAD_REQUEST);
            }

            if ($password->getUsePin()) {
                $encodePassword = ltrim($encodePassword, $pin);
            }

            $encodePassword = rtrim($encodePassword, $password->getSalt());

            return new JsonResponse(['password' => $encodePassword]);
        } catch (EntityNotFoundException $exception) {
            return new JsonResponse(['error' => 'Not found.'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            return new JsonResponse([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
