<?php

namespace App\Entity;

use App\Repository\CarritoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entidad Carrito.
 *
 * Representa el carrito activo de un usuario.
 */
#[ORM\Entity(repositoryClass: CarritoRepository::class)]
class Carrito
{
    /** ID único del carrito. */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /** Fecha en la que se creó el carrito. */
    #[ORM\Column]
    private ?\DateTimeImmutable $fechaCreacion = null;

    /** Total acumulado del carrito. */
    #[ORM\Column]
    #[Assert\Positive(message: 'El total debe ser positivo.')]
    private float $total = 0;

    /** Relación 1:1 con usuario (cada carrito pertenece a un usuario). */
    #[ORM\OneToOne(inversedBy: 'carrito', targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $usuario = null;

    /** Relación N:M simple con libros. */
    #[ORM\ManyToMany(targetEntity: Book::class, inversedBy: 'carritos')]
    private Collection $libros;

    public function __construct()
    {
        $this->fechaCreacion = new \DateTimeImmutable();
        $this->libros = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getFechaCreacion(): ?\DateTimeImmutable { return $this->fechaCreacion; }
    public function setFechaCreacion(\DateTimeImmutable $fechaCreacion): static { $this->fechaCreacion = $fechaCreacion; return $this; }
    public function getTotal(): float { return $this->total; }
    public function setTotal(float $total): static { $this->total = $total; return $this; }
    public function getUsuario(): ?User { return $this->usuario; }
    public function setUsuario(?User $usuario): static { $this->usuario = $usuario; return $this; }

    /** @return Collection<int, Book> */
    public function getLibros(): Collection { return $this->libros; }

    public function addLibro(Book $libro): static
    {
        if (!$this->libros->contains($libro)) {
            $this->libros->add($libro);
        }

        return $this;
    }

    public function removeLibro(Book $libro): static
    {
        $this->libros->removeElement($libro);

        return $this;
    }

    public function recalcularTotal(): static
    {
        $this->total = array_reduce(
            $this->libros->toArray(),
            static fn (float $acumulado, Book $libro): float => $acumulado + ((float) $libro->getPrecio()),
            0.0
        );

        return $this;
    }
}
