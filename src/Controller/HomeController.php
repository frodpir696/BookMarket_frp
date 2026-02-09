<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\CategoriaRepository;
use App\Repository\ValoracionRepository;
use App\Repository\PedidoRepository;
use App\Repository\MensajeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        BookRepository $bookRepo,
        CategoriaRepository $catRepo,
        ValoracionRepository $valRepo,
        PedidoRepository $pedidoRepo,
        MensajeRepository $mensajeRepo
    ): Response {
        $books = $bookRepo->findBy([], ['id' => 'DESC'], 5);
        $categorias = $catRepo->findAll();
        $valoraciones = $valRepo->findBy([], ['fecha' => 'DESC'], 5);

        $user = $this->getUser();
        $pedidos = $user ? $pedidoRepo->findBy(['usuario' => $user], ['fecha' => 'DESC'], 5) : [];
        $mensajes = $user ? $mensajeRepo->findBy(['receptor' => $user], ['fechaEnvio' => 'DESC'], 5) : [];

        return $this->render('home/index.html.twig', [
            'books' => $books,
            'categorias' => $categorias,
            'valoraciones' => $valoraciones,
            'pedidos' => $pedidos,
            'mensajes' => $mensajes
        ]);
    }
}
