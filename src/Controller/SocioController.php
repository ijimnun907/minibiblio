<?php

namespace App\Controller;

use App\Entity\Socio;
use App\Form\CambiarClaveType;
use App\Form\SocioType;
use App\Repository\SocioRepository;
use App\Security\SocioVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class SocioController extends AbstractController
{
    #[Route('/socio/listar', name: 'socio_listar')]
    public function listar(SocioRepository $socioRepository) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_BIBLIOTECARIO');
        $socios = $socioRepository->findSociosOrdenadosPorNombre();

        return $this->render('socio/listar.html.twig', [
            'socios' => $socios
        ]);
    }

    #[Route('/socio/modificar/{id}', name: 'socio_modificar')]
    public function modificar(Request $request, SocioRepository $socioRepository, Socio $socio) : Response
    {
        $this->denyAccessUnlessGranted(SocioVoter::EDIT, $socio);

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

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/socio/eliminar/{id}', name: 'socio_eliminar')]
    public function eliminar(Request $request, SocioRepository $socioRepository, Socio $socio) : Response
    {
        if ($request->request->has('confirmar')){
            try {
                $socioRepository->remove($socio);
                $socioRepository->save();
                $this->addFlash('success', 'Socio eliminado con exito');
                return $this->redirectToRoute('socio_listar');
            }
            catch (\Exception $e){
                $this->addFlash('error', 'No se ha podido eliminar el socio');
            }
        }

        return $this->render('socio/eliminar.html.twig', [
            'socio' => $socio
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/socio/nuevo', name: 'socio_nuevo')]
    public function nuevo(Request $request, SocioRepository $socioRepository) : Response
    {
        $socio = new Socio();
        $socioRepository->add($socio);

        return $this->modificar($request, $socioRepository, $socio);
    }

    #[Route('/clave/{id}', name: 'clave')]
    public function cambiarClave(Request $request, SocioRepository $socioRepository, UserPasswordHasherInterface $passwordHasher, Socio $socio) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(CambiarClaveType::class, $socio);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $socio->setClave($passwordHasher->hashPassword($socio, $form->get('newPassword')->getData())
            );
            $socioRepository->save();
            $this->addFlash('success', 'Contraseña cambiada con éxito');
            return $this->redirectToRoute('app_portada');
        }
        return $this->render('socio/cambiarClave.html.twig', [
            'form' => $form->createView(),
            'socio' => $socio,
        ]);
    }
}