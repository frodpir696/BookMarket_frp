<?php

namespace App\Controller;

use App\Entity\Carrito;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistroController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['GET','POST'])]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Hash de la contraseña
            $password = (string) $user->getPlainPassword();
            $user->setPassword($passwordHasher->hashPassword($user, $password));
            $user->setPlainPassword(null);

            // Crear carrito
            $carrito = new Carrito();
            $carrito->setUsuario($user);
            $user->setCarrito($carrito);

            // Persistir en DB
            $em->persist($user);
            $em->persist($carrito);
            $em->flush();

            $this->addFlash('success', 'Usuario registrado correctamente. Ya puedes iniciar sesión.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
