<?php

namespace App\Controller;

use App\Repository\AutorRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class AutorController extends AbstractController
{
    #[Route('/ap6', name: 'ap6')]
    public function listarOrdenadoConNumeroLibros(AutorRepository $autorRepository) : Response
    {
        $autores = $autorRepository->findAutoresOrdenadosPertenecientesLibros();
        return $this->render('autor/listarConNumeroLibros.html.twig', [
            'autores' => $autores
        ]);
    }
}