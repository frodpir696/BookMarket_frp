<?php

namespace App\Entity;

use App\Repository\MensajeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entidad Mensaje.
 *
 * Modelo simple para guardar notificaciones o mensajes internos.
 */
#[ORM\Entity(repositoryClass: MensajeRepository::class)]
class Mensaje
{
    /** Identificador único del mensaje. */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /** Texto del mensaje. */
    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: 'El contenido del mensaje es obligatorio.')]
    private ?string $contenido = null;

    /** Fecha de creación del mensaje. */
    #[ORM\Column]
    private ?\DateTimeImmutable $fecha = null;

    public function __construct() { $this->fecha = new \DateTimeImmutable(); }

    public function getId(): ?int { return $this->id; }
    public function getContenido(): ?string { return $this->contenido; }
    public function setContenido(string $contenido): static { $this->contenido = $contenido; return $this; }
    public function getFecha(): ?\DateTimeImmutable { return $this->fecha; }
    public function setFecha(\DateTimeImmutable $fecha): static { $this->fecha = $fecha; return $this; }
}
