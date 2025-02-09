<?php

namespace App\Controller;

use App\Entity\Socio;
use App\Form\SocioType;
use App\Repository\SocioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SocioController extends AbstractController
{
    #[Route('/socio/listar', name: 'socio_listar')]
    public function listar(SocioRepository $socioRepository) : Response
    {
        $socios = $socioRepository->findSociosOrdenadosPorNombre();

        return $this->render('socio/listar.html.twig', [
            'socios' => $socios
        ]);
    }

    #[Route('/socio/modificar/{id}', name: 'socio_modificar')]
    public function modificar(Request $request, SocioRepository $socioRepository, Socio $socio) : Response
    {
        $form = $this->createForm(SocioType::class, $socio);

        $form->handleRequest($request);

        $nuevo = $socio->getId() === null;

        if ($form->isSubmitted() && $form->isValid()){
            try {
                $socioRepository->save();
                if ($nuevo){
                    $this->addFlash('success', 'Socio creado con éxito');
                }
                else {
                    $this->addFlash('success', 'Socio modificado con éxito');
                }
                return $this->redirectToRoute('socio_listar');
            }
            catch (\Exception $e){
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }
        return $this->render('socio/modificar.html.twig', [
            'form' => $form->createView(),
            'socio' => $socio
        ]);
    }
}