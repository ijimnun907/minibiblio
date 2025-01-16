<?php

namespace App\Controller;

use App\Entity\Libro;
use App\Repository\LibroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibroController extends AbstractController
{
    #[Route('/libro/listar', name: 'listar')]
    public function listar(LibroRepository $libroRepository) : Response
    {
        $libros = $libroRepository->findLibrosOrdenadosOrdenAlfabetico();
        return $this->render('libro/listar.html.twig', [
            'libros' => $libros
        ]);
    }

    #[Route('/libro/autores/{id}', name: 'autores')]
    public function autores(Libro $libro) : Response
    {
        $autores = $libro->getAutores();
        return $this->render('libro/autores.html.twig', [
            'autores' => $autores
        ]);
    }
}