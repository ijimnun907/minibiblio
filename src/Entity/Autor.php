<?php

namespace App\Entity;

use App\Repository\AutorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AutorRepository::class)]
class Autor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 2, minMessage: 'El nombre debe tener dos caracteres como minimo')]
    #[Assert\Regex(
        pattern: '/^[A-Z]+$/',
        message: 'El nombre solo puede contener letras'
    )]
    #[Assert\NotBlank(message: 'El nombre es obligatorio')]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 2, minMessage: 'El apellido debe tener dos caracteres como minimo')]
    #[Assert\Regex(
        pattern: '/^[A-Z]+$/',
        message: 'El apellido solo puede contener letras'
    )]
    #[Assert\NotBlank(message: 'El apellido es obligatorio')]
    private ?string $apellidos = null;

    #[ORM\Column(type: 'date_immutable')]
    #[Assert\LessThan(value: 'today', message: 'La fecha debe ser inferior a la actual')]
    private ?\DateTimeImmutable $fechaNacimiento = null;

    #[ORM\ManyToMany(targetEntity: Libro::class, inversedBy: 'autores')]
    private Collection $libros;

    public function __construct()
    {
        $this->libros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): static
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeImmutable
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(\DateTimeImmutable $fechaNacimiento): static
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * @return Collection<int, Libro>
     */
    public function getLibros(): Collection
    {
        return $this->libros;
    }

    public function addLibro(Libro $libro): static
    {
        if (!$this->libros->contains($libro)) {
            $this->libros->add($libro);
        }

        return $this;
    }

    public function removeLibro(Libro $libro): static
    {
        $this->libros->removeElement($libro);

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNombre() . ' ' . $this->getApellidos();
    }
}
