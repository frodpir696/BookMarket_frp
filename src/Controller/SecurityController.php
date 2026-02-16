<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Controlador de seguridad para login y logout.
 */
class SecurityController extends AbstractController
{
    /** Muestra el formulario de login. */
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('user/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    /** Ruta reservada para que Symfony gestione el logout automáticamente. */
    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('Este método está vacío a propósito: lo intercepta el firewall.');
    }
}
