<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Carrito;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/carrito')]
#[IsGranted('ROLE_USER')]
class CarritoController extends AbstractController
{
    #[Route('/', name: 'app_carrito_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $carrito = $this->obtenerOCrearCarrito($em);

        return $this->render('carrito/index.html.twig', [
            'carrito' => $carrito,
        ]);
    }

    #[Route('/add/{id}', name: 'app_carrito_add', methods: ['POST'])]
    public function add(Book $book, EntityManagerInterface $em): RedirectResponse
    {
        $carrito = $this->obtenerOCrearCarrito($em);
        $carrito->addLibro($book)->recalcularTotal();
        $em->flush();

        $this->addFlash('success', sprintf('"%s" añadido al carrito.', $book->getTitulo()));

        return $this->redirectToRoute('app_carrito_index');
    }

    #[Route('/remove/{id}', name: 'app_carrito_remove', methods: ['POST'])]
    public function remove(Book $book, EntityManagerInterface $em): RedirectResponse
    {
        $carrito = $this->obtenerOCrearCarrito($em);
        $carrito->removeLibro($book)->recalcularTotal();
        $em->flush();

        $this->addFlash('success', sprintf('"%s" eliminado del carrito.', $book->getTitulo()));

        return $this->redirectToRoute('app_carrito_index');
    }

    private function obtenerOCrearCarrito(EntityManagerInterface $em): Carrito
    {
        $usuario = $this->getUser();
        if (!$usuario instanceof \App\Entity\User) {
            throw $this->createAccessDeniedException('Debes iniciar sesión para usar el carrito.');
        }

        $carrito = $usuario->getCarrito();
        if ($carrito instanceof Carrito) {
            return $carrito;
        }

        $carrito = new Carrito();
        $carrito->setUsuario($usuario);
        $usuario->setCarrito($carrito);
        $em->persist($carrito);
        $em->flush();

        return $carrito;
    }
}
