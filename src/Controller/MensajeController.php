<?php

namespace App\Controller;

use App\Entity\Mensaje;
use App\Form\MensajeType;
use App\Repository\MensajeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mensaje')]
final class MensajeController extends AbstractController
{
    #[Route('/', name: 'mensaje_index', methods: ['GET'])]
    public function index(MensajeRepository $mensajeRepository): Response
    {
        return $this->render('mensaje/index.html.twig', [
            'mensajes' => $mensajeRepository->findAll(),
        ]);
    }

    #[Route('/nuevo', name: 'mensaje_nuevo', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mensaje = new Mensaje();
        $form = $this->createForm(MensajeType::class, $mensaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mensaje);
            $entityManager->flush();

            return $this->redirectToRoute('mensaje_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mensaje/new.html.twig', [
            'mensaje' => $mensaje,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'mensaje_mostrar', methods: ['GET'])]
    public function show(Mensaje $mensaje): Response
    {
        return $this->render('mensaje/show.html.twig', [
            'mensaje' => $mensaje,
        ]);
    }

    #[Route('/{id}/editar', name: 'mensaje_editar', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mensaje $mensaje, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MensajeType::class, $mensaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('mensaje_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mensaje/edit.html.twig', [
            'mensaje' => $mensaje,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'mensaje_borrar', methods: ['POST'])]
    public function delete(Request $request, Mensaje $mensaje, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mensaje->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mensaje);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mensaje_index', [], Response::HTTP_SEE_OTHER);
    }
}
