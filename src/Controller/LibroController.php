<?php

namespace App\Controller;

use App\Entity\Editorial;
use App\Entity\Libro;
use App\Repository\LibroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibroController extends AbstractController
{
    #[Route('/ap1', name: 'ap1')]
    public function listar(LibroRepository $libroRepository) : Response
    {
        $libros = $libroRepository->findLibrosOrdenadosOrdenAlfabetico();
        return $this->render('libro/listar.html.twig', [
            'libros' => $libros
        ]);
    }

    #[Route('/ap2', name: 'ap2')]
    public function listarAnioDescendente(LibroRepository $libroRepository) : Response
    {
        $libros = $libroRepository->findLibrosAnioDescendente();
        return $this->render('libro/listar.html.twig', [
            'libros' => $libros
        ]);
    }

    #[Route('/ap3/{palabra}', name: 'ap3')]
    public function listarPorPalabra(LibroRepository $libroRepository, string $palabra) : Response
    {
        $libros = $libroRepository->findLibrosConPalabra($palabra);
        return $this->render('libro/listar.html.twig', [
            'libros' => $libros
        ]);
    }

    #[Route('/ap4', name: 'ap4')]
    public function listarPorEditorialNoContenerLetra(LibroRepository $libroRepository) : Response
    {
        $libros = $libroRepository->findLibrosEditorialNoContenieneLetra();
        return $this->render('libro/listar.html.twig', [
            'libros' => $libros
        ]);
    }

    #[Route('/ap5', name: 'ap5')]
    public function listarLibrosConUnAutor(LibroRepository $libroRepository) : Response
    {
        $libros = $libroRepository->findLibrosConUnAutor();
        return $this->render('libro/listar.html.twig', [
            'libros' => $libros
        ]);
    }

    #[Route('/ap7', name: 'ap7')]
    public function listarLibrosConAutores(LibroRepository $libroRepository) : Response
    {
        $libros = $libroRepository->findLibrosOrdenadosJuntoAutores();
        return $this->render('libro/listarConAutores.html.twig', [
            'libros' => $libros
        ]);
    }

    #[Route('/ap8/{id}', name: 'autores')]
    public function autores(Libro $libro) : Response
    {
        $autores = $libro->getAutores();
        return $this->render('libro/autores.html.twig', [
            'autores' => $autores
        ]);
    }

    #[Route('/librosEditorial/{id}', name: 'librosEditorial')]
    public function listarLibrosDeEditorial(Editorial $editorial)
    {
        $libros = $editorial->getLibros();
        return $this->render('libro/listarLibrosDeEditoriales.html.twig', [
            'libros' => $libros
        ]);
    }
}