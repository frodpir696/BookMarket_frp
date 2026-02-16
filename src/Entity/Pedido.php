<?php

namespace App\Entity;

use App\Repository\PedidoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entidad Pedido.
 *
 * Registra una compra realizada por un usuario.
 */
#[ORM\Entity(repositoryClass: PedidoRepository::class)]
class Pedido
{
    /** ID único del pedido. */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /** Fecha en la que se creó el pedido. */
    #[ORM\Column]
    private ?\DateTimeImmutable $fecha = null;

    /** Importe total del pedido. */
    #[ORM\Column]
    #[Assert\Positive(message: 'El total del pedido debe ser positivo.')]
    private ?float $total = null;

    /** Estado del pedido (pendiente, enviado, etc.). */
    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'El estado del pedido es obligatorio.')]
    private ?string $estado = null;

    /**
     * Relación N:1 con Usuario.
     * Un usuario puede tener muchos pedidos.
     */
    #[ORM\ManyToOne(inversedBy: 'pedidos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $usuario = null;

    public function __construct() { $this->fecha = new \DateTimeImmutable(); }

    public function getId(): ?int { return $this->id; }
    public function getFecha(): ?\DateTimeImmutable { return $this->fecha; }
    public function setFecha(\DateTimeImmutable $fecha): static { $this->fecha = $fecha; return $this; }
    public function getTotal(): ?float { return $this->total; }
    public function setTotal(float $total): static { $this->total = $total; return $this; }
    public function getEstado(): ?string { return $this->estado; }
    public function setEstado(string $estado): static { $this->estado = $estado; return $this; }
    public function getUsuario(): ?User { return $this->usuario; }
    public function setUsuario(?User $usuario): static { $this->usuario = $usuario; return $this; }
}
