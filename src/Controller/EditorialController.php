<?php

namespace App\Controller;

use App\Repository\EditorialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditorialController extends AbstractController
{
    #[Route('/ap9', name: 'ap9')]
    public function listarEditorialesConMenosCincoLibros(EditorialRepository $editorialRepository) : Response
    {
        $editoriales = $editorialRepository->findEditorialesConMenosCincoLibros();
        return $this->render('editorial/listarConMenosCincoLibros.html.twig', [
            'editoriales' => $editoriales
        ]);
    }
}