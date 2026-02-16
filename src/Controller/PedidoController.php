<?php

namespace App\Controller;

use App\Entity\Pedido;
use App\Form\PedidoType;
use App\Repository\PedidoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Controlador básico para pedidos del usuario.
 */
#[Route('/pedido')]
#[IsGranted('ROLE_USER')]
final class PedidoController extends AbstractController
{
    #[Route('/', name: 'app_pedido_index', methods: ['GET'])]
    public function index(PedidoRepository $pedidoRepository): Response
    {
        return $this->render('pedido/index.html.twig', [
            'pedidos' => $pedidoRepository->findBy(['usuario' => $this->getUser()]),
        ]);
    }

    #[Route('/new', name: 'app_pedido_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $pedido = new Pedido();
        $form = $this->createForm(PedidoType::class, $pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pedido->setUsuario($this->getUser());
            $em->persist($pedido);
            $em->flush();
            $this->addFlash('success', 'Pedido creado correctamente.');
            return $this->redirectToRoute('app_pedido_index');
        }

        return $this->render('pedido/new.html.twig', ['form' => $form]);
    }
}
