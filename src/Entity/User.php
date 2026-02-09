<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: Book::class, orphanRemoval: true)]
    private Collection $books;

    public function __construct() { $this->books = new ArrayCollection(); }

    public function getId(): ?int { return $this->id; }
    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): static { $this->email = $email; return $this; }
    public function getUserIdentifier(): string { return (string) $this->email; }

    public function getRoles(): array {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
    public function setRoles(array $roles): static { $this->roles = $roles; return $this; }
    public function getPassword(): ?string { return $this->password; }
    public function setPassword(string $password): static { $this->password = $password; return $this; }

    #[\Deprecated] public function eraseCredentials(): void {}

    /** @return Collection<int, Book> */
    public function getBooks(): Collection { return $this->books; }
    public function addBook(Book $book): static {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setUsuario($this);
        }
        return $this;
    }
    public function removeBook(Book $book): static {
        if ($this->books->removeElement($book)) {
            if ($book->getUsuario() === $this) { $book->setUsuario(null); }
        }
        return $this;
    }

    public function __toString(): string { return $this->email ?? ''; }
}

