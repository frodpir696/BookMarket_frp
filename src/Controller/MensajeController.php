<?php

namespace App\Controller;

use App\Entity\Mensaje;
use App\Form\MensajeType;
use App\Repository\MensajeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * CRUD sencillo de mensajes.
 */
#[Route('/mensaje')]
#[IsGranted('ROLE_USER')]
final class MensajeController extends AbstractController
{
    #[Route('/', name: 'app_mensaje_index', methods: ['GET'])]
    public function index(MensajeRepository $mensajeRepository): Response
    {
        return $this->render('mensaje/index.html.twig', ['mensajes' => $mensajeRepository->findAll()]);
    }

    #[Route('/new', name: 'app_mensaje_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $mensaje = new Mensaje();
        $form = $this->createForm(MensajeType::class, $mensaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($mensaje);
            $em->flush();
            $this->addFlash('success', 'Mensaje guardado correctamente.');
            return $this->redirectToRoute('app_mensaje_index');
        }

        return $this->render('mensaje/new.html.twig', ['form' => $form]);
    }
}
