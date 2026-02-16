<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Controlador de administración básica de usuarios.
 */
#[Route('/usuario')]
#[IsGranted('ROLE_ADMIN')]
final class UserController extends AbstractController
{
    /** Lista de usuarios (solo admins). */
    #[Route('/', name: 'usuario_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/list.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
}
