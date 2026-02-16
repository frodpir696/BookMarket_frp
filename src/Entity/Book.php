<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entidad Libro.
 *
 * Mantiene la información básica del libro usado que se pone a la venta.
 */
#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    /** ID interno del libro. */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /** Título del libro. */
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'El título es obligatorio.')]
    private ?string $titulo = null;

    /** Autor del libro. */
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'El autor es obligatorio.')]
    private ?string $autor = null;

    /** Descripción breve del estado/contenido del libro. */
    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: 'La descripción es obligatoria.')]
    private ?string $descripcion = null;

    /** Precio de venta del libro. */
    #[ORM\Column]
    #[Assert\Positive(message: 'El precio debe ser positivo.')]
    private ?float $precio = null;

    /** Estado físico (nuevo, usado, etc.). */
    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'El estado es obligatorio.')]
    private ?string $estado = null;

    /** Fecha de publicación del libro en la plataforma. */
    #[ORM\Column]
    private ?\DateTimeImmutable $fechaPublicacion = null;

    /**
     * Relación N:1 con Categoría.
     * Un libro solo pertenece a una categoría.
     */
    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categoria $categoria = null;

    /**
     * Relación N:1 con Usuario.
     * Cada libro tiene un único vendedor (usuario).
     */
    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $usuario = null;

    /**
     * Relación N:M con Carrito.
     * Un libro puede estar en varios carritos.
     */
    #[ORM\ManyToMany(targetEntity: Carrito::class, mappedBy: 'libros')]
    private Collection $carritos;

    public function __construct()
    {
        $this->fechaPublicacion = new \DateTimeImmutable();
        $this->carritos = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getTitulo(): ?string { return $this->titulo; }
    public function setTitulo(string $titulo): static { $this->titulo = $titulo; return $this; }
    public function getAutor(): ?string { return $this->autor; }
    public function setAutor(string $autor): static { $this->autor = $autor; return $this; }
    public function getDescripcion(): ?string { return $this->descripcion; }
    public function setDescripcion(string $descripcion): static { $this->descripcion = $descripcion; return $this; }
    public function getPrecio(): ?float { return $this->precio; }
    public function setPrecio(float $precio): static { $this->precio = $precio; return $this; }
    public function getEstado(): ?string { return $this->estado; }
    public function setEstado(string $estado): static { $this->estado = $estado; return $this; }
    public function getFechaPublicacion(): ?\DateTimeImmutable { return $this->fechaPublicacion; }
    public function setFechaPublicacion(\DateTimeImmutable $fechaPublicacion): static { $this->fechaPublicacion = $fechaPublicacion; return $this; }
    public function getCategoria(): ?Categoria { return $this->categoria; }
    public function setCategoria(?Categoria $categoria): static { $this->categoria = $categoria; return $this; }
    public function getUsuario(): ?User { return $this->usuario; }
    public function setUsuario(?User $usuario): static { $this->usuario = $usuario; return $this; }

    /** @return Collection<int, Carrito> */
    public function getCarritos(): Collection { return $this->carritos; }

    public function __toString(): string { return $this->titulo ?? ''; }
}
