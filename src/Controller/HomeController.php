<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controlador de la página de inicio.
 */
final class HomeController extends AbstractController
{
    /**
     * Muestra una portada simple con resumen del proyecto y listados básicos.
     */
    #[Route('/', name: 'home')]
    public function index(BookRepository $bookRepository, CategoriaRepository $categoriaRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'books' => $bookRepository->findBy([], ['id' => 'DESC'], 5),
            'categorias' => $categoriaRepository->findAll(),
        ]);
    }
}
