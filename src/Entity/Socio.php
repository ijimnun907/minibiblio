<?php

namespace App\Entity;

use App\Repository\SocioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: SocioRepository::class)]
#[UniqueEntity(fields: 'dni', message: 'Ya existe un socio con ese dni')]
class Socio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Regex(pattern: '/^[0-9]{8}[A-Z]$/', message: 'El dni debe ser valido')]
    private ?string $dni;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Los apellidos no pueden estar en blanco')]
    private ?string $apellidos = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'El nombre no pueden estar en blanco')]
    private ?string $nombre = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $esDocente = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $esEstudiante = null;

    #[ORM\OneToMany(targetEntity: Libro::class, mappedBy: 'socio')]
    private Collection $libros;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telefono = null;

    #[Assert\Callback]
    public function validarOpciones(ExecutionContextInterface $context): void
    {
        if (!$this->esEstudiante && !$this->esDocente) {
            $context->buildViolation('Debe ser estudiante, docente, o la dos.')
                ->atPath('esDocente') // Puedes asociarlo a cualquier campo o a ambos
                ->addViolation();
        }
    }

    public function __construct()
    {
        $this->libros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): static
    {
        $this->dni = $dni;

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

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function isEsDocente(): ?bool
    {
        return $this->esDocente;
    }

    public function setEsDocente(bool $esDocente): static
    {
        $this->esDocente = $esDocente;

        return $this;
    }

    public function isEsEstudiante(): ?bool
    {
        return $this->esEstudiante;
    }

    public function setEsEstudiante(bool $esEstudiante): static
    {
        $this->esEstudiante = $esEstudiante;

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
            $libro->setSocio($this);
        }

        return $this;
    }

    public function removeLibro(Libro $libro): static
    {
        if ($this->libros->removeElement($libro)) {
            // set the owning side to null (unless already changed)
            if ($libro->getSocio() === $this) {
                $libro->setSocio(null);
            }
        }

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getApellidos() . ', ' . $this->getNombre();
    }
}
