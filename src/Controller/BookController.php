<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * CRUD completo de Libro.
 */
#[Route('/book')]
#[IsGranted('ROLE_USER')]
final class BookController extends AbstractController
{
    /** Lista todos los libros. */
    #[Route('/', name: 'app_book_index', methods: ['GET'])]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', ['books' => $bookRepository->findAll()]);
    }

    /** Crea un nuevo libro. */
    #[Route('/new', name: 'app_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setUsuario($this->getUser());
            $em->persist($book);
            $em->flush();
            $this->addFlash('success', 'Libro creado correctamente.');
            return $this->redirectToRoute('app_book_index');
        }

        return $this->render('book/new.html.twig', ['form' => $form]);
    }

    /** Muestra detalle de un libro. */
    #[Route('/{id}', name: 'app_book_show', methods: ['GET'])]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', ['book' => $book]);
    }

    /** Edita un libro existente. */
    #[Route('/{id}/edit', name: 'app_book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Book $book, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Libro actualizado correctamente.');
            return $this->redirectToRoute('app_book_index');
        }

        return $this->render('book/edit.html.twig', ['form' => $form, 'book' => $book]);
    }

    /** Elimina un libro comprobando token CSRF. */
    #[Route('/{id}/delete', name: 'app_book_delete', methods: ['POST'])]
    public function delete(Request $request, Book $book, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $book->getId(), (string) $request->request->get('_token'))) {
            $em->remove($book);
            $em->flush();
            $this->addFlash('success', 'Libro eliminado correctamente.');
        }

        return $this->redirectToRoute('app_book_index');
    }
}
