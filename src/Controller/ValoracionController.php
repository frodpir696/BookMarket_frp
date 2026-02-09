<?php

namespace App\Controller;

use App\Entity\Valoracion;
use App\Form\ValoracionType;
use App\Repository\ValoracionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/valoracion')]
final class ValoracionController extends AbstractController
{
    #[Route('/', name: 'app_valoracion_index', methods: ['GET'])]
    public function index(ValoracionRepository $valoracionRepository): Response
    {
        return $this->render('valoracion/index.html.twig', [
            'valoraciones' => $valoracionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_valoracion_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $valoracion = new Valoracion();
        $valoracion->setEmisor($this->getUser());
        $form = $this->createForm(ValoracionType::class, $valoracion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $valoracion->setFecha(new \DateTimeImmutable());
            $em->persist($valoracion);
            $em->flush();
            return $this->redirectToRoute('app_valoracion_index');
        }

        return $this->render('valoracion/new.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}', name: 'app_valoracion_show', methods: ['GET'])]
    public function show(Valoracion $valoracion): Response
    {
        return $this->render('valoracion/show.html.twig', ['valoracion' => $valoracion]);
    }

    #[Route('/{id}/edit', name: 'app_valoracion_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Valoracion $valoracion, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ValoracionType::class, $valoracion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_valoracion_index');
        }

        return $this->render('valoracion/edit.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}/delete', name: 'app_valoracion_delete', methods: ['POST'])]
    public function delete(Request $request, Valoracion $valoracion, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$valoracion->getId(), $request->request->get('_token'))) {
            $em->remove($valoracion);
            $em->flush();
        }
        return $this->redirectToRoute('app_valoracion_index');
    }
}
