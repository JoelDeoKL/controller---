<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\DemandeType;
use App\Entity\Demande;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;


class DemandeController extends AbstractController
{

    #[Route('/mes_demandes', name: 'mes_demandes')]
    public function mes_demandes(EntityManagerInterface $entityManager): Response
    {
        $demandes = $entityManager->getRepository(Demande::class)->findAll();

        return $this->render('stagiaire/mes_demandes.html.twig', ['demandes' => $demandes]);
    }

    #[Route('/demandes', name: 'demandes')]
    public function demandes(EntityManagerInterface $entityManager): Response
    {
        $demandes = $entityManager->getRepository(Demande::class)->findAll();

        return $this->render('rh/demandes.html.twig', ['demandes' => $demandes]);
    }

    #[Route('/editer_demande/{id?0}', name: 'editer_demande')]
    public function editer_demande(Demande $demande = null, ManagerRegistry $doctrine, Request $request): Response
    {
        $new = false;
        if(!$demande){
            $new = true;
            $demande = new Demande();
        }

        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            $manager = $doctrine->getManager();
            $manager->persist($demande);

            $manager->flush();

            if($new){
                $message = "La demande a été ajouter avec succès";
            }else{
                $message = "La demande a été editer avec succès";
            }

            $this->addFlash("succes", $message);

            return $this->redirectToRoute("mes_demandes");
        }else{
            return $this->render('stagiaire/demande.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    #[Route('/details_demande/{id<\d+>}', name: 'details_demande')]
    public function details_demande(ManagerRegistry $doctrine, Demande $demande= null, $id): Response
    {
        if(!$demande){
            $this->addFlash('error', "Cette demande n'existe pas !");
            return $this->redirectToRoute("mes_demandes");
        }
        return $this->render('stagiaire/demande_details.html.twig', ['demande' => $demande]);
    }

    #[Route('/delete_demande/{id?0}', name: 'delete_demande')]
    public function delete_demande(Demande $demande = null, ManagerRegistry $doctrine, Request $request, $id): Response
    {

        $repository = $doctrine->getRepository(Demande::class);
        $demande = $repository->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($demande);

        $manager->flush();

        $message = "La demande a été supprimer avec succès";


        $this->addFlash("succes", $message);

        return $this->redirectToRoute("mes_demandes");

    }
}
