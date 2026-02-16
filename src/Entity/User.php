<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Este email ya está registrado.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    #[Assert\NotBlank(message: 'El nombre es obligatorio.')]
    private ?string $nombre = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: 'El email es obligatorio.')]
    #[Assert\Email(message: 'Introduce un email válido.')]
    private ?string $email = null;

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 20)]
    private string $rol = 'ROLE_USER';

    #[ORM\Column]
    private ?\DateTimeImmutable $fechaRegistro = null;

    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: Book::class)]
    private Collection $books;

    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: Pedido::class)]
    private Collection $pedidos;

    #[ORM\OneToOne(mappedBy: 'usuario', targetEntity: Carrito::class, cascade: ['persist', 'remove'])]
    private ?Carrito $carrito = null;

    // Campo temporal para contraseña sin mapear
    #[Assert\NotBlank(message: 'La contraseña es obligatoria.')]
    #[Assert\Length(min: 6, minMessage: 'La contraseña debe tener al menos 6 caracteres.')]
    private ?string $plainPassword = null;

    public function __construct()
    {
        $this->books = new ArrayCollection();
        $this->pedidos = new ArrayCollection();
        $this->fechaRegistro = new \DateTimeImmutable();
    }

    // ---------------- Getters / Setters ----------------
    public function getId(): ?int { return $this->id; }
    public function getNombre(): ?string { return $this->nombre; }
    public function setNombre(string $nombre): static { $this->nombre = $nombre; return $this; }
    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): static { $this->email = $email; return $this; }
    public function getPassword(): ?string { return $this->password; }
    public function setPassword(string $password): static { $this->password = $password; return $this; }
    public function getRol(): string { return $this->rol; }
    public function setRol(string $rol): static { $this->rol = $rol; return $this; }
    public function getFechaRegistro(): ?\DateTimeImmutable { return $this->fechaRegistro; }
    public function setFechaRegistro(\DateTimeImmutable $fechaRegistro): static { $this->fechaRegistro = $fechaRegistro; return $this; }

    public function getUserIdentifier(): string { return (string) $this->email; }
    public function getRoles(): array { return [$this->rol]; }
    public function setRoles(array $roles): static { $this->rol = $roles[0] ?? 'ROLE_USER'; return $this; }
    public function eraseCredentials(): void {}

    public function getPlainPassword(): ?string { return $this->plainPassword; }
    public function setPlainPassword(?string $plainPassword): static { $this->plainPassword = $plainPassword; return $this; }

    public function getBooks(): Collection { return $this->books; }
    public function addBook(Book $book): static { if (!$this->books->contains($book)) { $this->books->add($book); $book->setUsuario($this); } return $this; }

    public function getPedidos(): Collection { return $this->pedidos; }
    public function addPedido(Pedido $pedido): static { if (!$this->pedidos->contains($pedido)) { $this->pedidos->add($pedido); $pedido->setUsuario($this); } return $this; }

    public function getCarrito(): ?Carrito { return $this->carrito; }
    public function setCarrito(Carrito $carrito): static { $this->carrito = $carrito; if ($carrito->getUsuario() !== $this) { $carrito->setUsuario($this); } return $this; }

    public function __toString(): string { return $this->nombre ?? $this->email ?? ''; }
}
