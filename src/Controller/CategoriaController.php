<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\BookRepository;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * CRUD completo de Categoría.
 */
#[Route('/categoria')]
#[IsGranted('ROLE_USER')]
final class CategoriaController extends AbstractController
{
    #[Route('/', name: 'app_categoria_index', methods: ['GET'])]
    public function index(CategoriaRepository $categoriaRepository): Response
    {
        return $this->render('categoria/index.html.twig', ['categorias' => $categoriaRepository->findAll()]);
    }

    #[Route('/new', name: 'app_categoria_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $categoria = new Categoria();
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($categoria);
            $em->flush();
            $this->addFlash('success', 'Categoría creada correctamente.');
            return $this->redirectToRoute('app_categoria_index');
        }

        return $this->render('categoria/new.html.twig', ['form' => $form]);
    }

    #[Route('/{id}', name: 'app_categoria_show', methods: ['GET'])]
    public function show(Categoria $categoria, BookRepository $bookRepository): Response
    {
        return $this->render('categoria/show.html.twig', [
            'categoria' => $categoria,
            'books' => $bookRepository->findByCategoria($categoria),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categoria_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categoria $categoria, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Categoría actualizada correctamente.');
            return $this->redirectToRoute('app_categoria_index');
        }

        return $this->render('categoria/edit.html.twig', ['form' => $form, 'categoria' => $categoria]);
    }

    #[Route('/{id}/delete', name: 'app_categoria_delete', methods: ['POST'])]
    public function delete(Request $request, Categoria $categoria, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $categoria->getId(), (string) $request->request->get('_token'))) {
            $em->remove($categoria);
            $em->flush();
            $this->addFlash('success', 'Categoría eliminada correctamente.');
        }

        return $this->redirectToRoute('app_categoria_index');
    }
}
