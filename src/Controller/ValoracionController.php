<?php

namespace App\Controller;

use App\Entity\Valoracion;
use App\Form\ValoracionType;
use App\Repository\ValoracionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/valoracion')]
final class ValoracionController extends AbstractController
{
    #[Route('/', name: 'valoracion_index', methods: ['GET'])]
    public function index(ValoracionRepository $valoracionRepository): Response
    {
        return $this->render('valoracion/index.html.twig', [
            'valoraciones' => $valoracionRepository->findAll(),
        ]);
    }

    #[Route('/nuevo', name: 'valoracion_nuevo', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $valoracion = new Valoracion();
        $form = $this->createForm(ValoracionType::class, $valoracion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($valoracion);
            $entityManager->flush();

            return $this->redirectToRoute('valoracion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('valoracion/new.html.twig', [
            'valoracion' => $valoracion,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'valoracion_mostrar', methods: ['GET'])]
    public function show(Valoracion $valoracion): Response
    {
        return $this->render('valoracion/show.html.twig', [
            'valoracion' => $valoracion,
        ]);
    }

    #[Route('/{id}/editar', name: 'valoracion_editar', methods: ['GET', 'POST'])]
    public function edit(Request $request, Valoracion $valoracion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ValoracionType::class, $valoracion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('valoracion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('valoracion/edit.html.twig', [
            'valoracion' => $valoracion,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'valoracion_borrar', methods: ['POST'])]
    public function delete(Request $request, Valoracion $valoracion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$valoracion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($valoracion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('valoracion_index', [], Response::HTTP_SEE_OTHER);
    }
}
