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

#[Route('/mensaje')]
final class MensajeController extends AbstractController
{
    #[Route('/', name: 'app_mensaje_index', methods: ['GET'])]
    public function index(MensajeRepository $mensajeRepository): Response
    {
        return $this->render('mensaje/index.html.twig', [
            'mensajes' => $mensajeRepository->findBy(['receptor' => $this->getUser()]),
        ]);
    }

    #[Route('/new', name: 'app_mensaje_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $mensaje = new Mensaje();
        $mensaje->setEmisor($this->getUser());
        $form = $this->createForm(MensajeType::class, $mensaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mensaje->setFechaEnvio(new \DateTimeImmutable());
            $em->persist($mensaje);
            $em->flush();
            return $this->redirectToRoute('app_mensaje_index');
        }

        return $this->render('mensaje/new.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}', name: 'app_mensaje_show', methods: ['GET'])]
    public function show(Mensaje $mensaje): Response
    {
        if ($mensaje->getReceptor() !== $this->getUser() && $mensaje->getEmisor() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('mensaje/show.html.twig', ['mensaje' => $mensaje]);
    }

    #[Route('/{id}/delete', name: 'app_mensaje_delete', methods: ['POST'])]
    public function delete(Request $request, Mensaje $mensaje, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mensaje->getId(), $request->request->get('_token'))) {
            $em->remove($mensaje);
            $em->flush();
        }
        return $this->redirectToRoute('app_mensaje_index');
    }
}
