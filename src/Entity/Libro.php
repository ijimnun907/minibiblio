<?php

namespace App\Entity;

use App\Repository\LibroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LibroRepository::class)]
class Libro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(type: 'date_immutable')]
    private ?\DateTimeImmutable $anioPublicacion = null;

    #[ORM\Column]
    private ?int $paginas = null;

    #[ORM\ManyToOne(targetEntity: Editorial::class, inversedBy: 'libros')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Editorial $editorial = null;

    #[ORM\ManyToMany(targetEntity: Autor::class, mappedBy: 'libros')]
    private Collection $autores;

    public function __construct()
    {
        $this->autores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getAnioPublicacion(): ?\DateTimeImmutable
    {
        return $this->anioPublicacion;
    }

    public function setAnioPublicacion(\DateTimeImmutable $anioPublicacion): static
    {
        $this->anioPublicacion = $anioPublicacion;

        return $this;
    }

    public function getPaginas(): ?int
    {
        return $this->paginas;
    }

    public function setPaginas(int $paginas): static
    {
        $this->paginas = $paginas;

        return $this;
    }

    public function getEditorial(): ?Editorial
    {
        return $this->editorial;
    }

    public function setEditorial(?Editorial $editorial): static
    {
        $this->editorial = $editorial;

        return $this;
    }

    /**
     * @return Collection<int, Autor>
     */
    public function getAutores(): Collection
    {
        return $this->autores;
    }

    public function addAutore(Autor $autore): static
    {
        if (!$this->autores->contains($autore)) {
            $this->autores->add($autore);
            $autore->addLibro($this);
        }

        return $this;
    }

    public function removeAutore(Autor $autore): static
    {
        if ($this->autores->removeElement($autore)) {
            $autore->removeLibro($this);
        }

        return $this;
    }
}
