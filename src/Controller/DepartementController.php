<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Departement;
use App\Form\DepartementType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class DepartementController extends AbstractController
{
    #[Route('/departements', name: 'departements')]
    public function departements(EntityManagerInterface $entityManager): Response
    {
        $departements = $entityManager->getRepository(Departement::class)->findAll();

        return $this->render('rh/departements.html.twig', ['departements' => $departements]);
    }

    #[Route('/editer_departement/{id?0}', name: 'editer_departement')]
    public function editer_departement(Departement $departement = null, ManagerRegistry $doctrine, Request $request): Response
    {
        $new = false;
        if(!$departement){
            $new = true;
            $departement = new Departement();
        }

        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            $manager = $doctrine->getManager();
            $manager->persist($departement);

            $manager->flush();

            if($new){
                $message = "Le departement a été ajouter avec succès";
            }else{
                $message = "Le departement a été editer avec succès";
            }

            $this->addFlash("succes", $message);

            return $this->redirectToRoute("departements");
        }else{
            return $this->render('rh/add_departement.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    #[Route('/details_departement/{id<\d+>}', name: 'details_departement')]
    public function details_departement(ManagerRegistry $doctrine, Departement $departement= null, $id): Response
    {
        if(!$departement){
            $this->addFlash('error', "Cette departement n'existe pas !");
            return $this->redirectToRoute("mes_departements");
        }
        return $this->render('rh/departement_details.html.twig', ['departement' => $departement]);
    }

    #[Route('/delete_departement/{id?0}', name: 'delete_departement')]
    public function delete_departement(Departement $departement = null, ManagerRegistry $doctrine, Request $request, $id): Response
    {

        $repository = $doctrine->getRepository(Departement::class);
        $departement = $repository->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($departement);

        $manager->flush();

        $message = "La departement a été supprimer avec succès";


        $this->addFlash("succes", $message);

        return $this->redirectToRoute("mes_departements");

    }
}
