<?php

namespace App\Controller;

use App\Entity\Editorial;
use App\Entity\Libro;
use App\Form\LibroType;
use App\Repository\LibroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/libro/modificar/{id}', name: 'libro_modificar')]
    public function modificar(Request $request, LibroRepository $libroRepository,Libro $libro) : Response
    {
        $form = $this->createForm(LibroType::class, $libro);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            try {
                $libroRepository->save();
                $this->addFlash('success', 'Cambios guardados con exito');
                return $this->redirectToRoute('ap1');
            }
            catch (\Exception $e){
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }

        return $this->render('libro/modificar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/libro/eliminar/{id}', name: 'libro_eliminar')]
    public function eliminar(Request $request,LibroRepository $libroRepository,Libro $libro) : Response
    {
        if ($request->request->has('confirmar')){
            try {
                $libroRepository->remove($libro);
                $libroRepository->save();
                $this->addFlash('success', 'Libro eliminado con éxito');
                return $this->redirectToRoute('ap1');
            }
            catch (\Exception $e){
                $this->addFlash('error', 'No se ha podido eliminar el libro');
            }
        }

        return $this->render('libro/eliminar.html.twig', [
            'libro' => $libro
        ]);
    }
}