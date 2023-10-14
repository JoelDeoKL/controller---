<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tache;
use App\Form\TacheType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class TacheController extends AbstractController
{
    #[Route('/mes_taches', name: 'mes_taches')]
    public function mes_taches(EntityManagerInterface $entityManager): Response
    {
        $taches = $entityManager->getRepository(Tache::class)->findAll();

        return $this->render('stagiaire/taches.html.twig', ['taches' => $taches]);
    }

    #[Route('/taches_encours', name: 'taches_encours')]
    public function taches_encours(EntityManagerInterface $entityManager): Response
    {
        $taches = $entityManager->getRepository(Tache::class)->findAll();

        return $this->render('stagiaire/taches.html.twig', ['taches' => $taches]);
    }

    #[Route('/taches_remplies', name: 'taches_remplies')]
    public function taches_remplies(EntityManagerInterface $entityManager): Response
    {
        $taches = $entityManager->getRepository(Tache::class)->findAll();

        return $this->render('stagiaire/taches.html.twig', ['taches' => $taches]);
    }

    #[Route('/editer_tache/{id?0}', name: 'editer_tache')]
    public function editer_tache(Tache $tache = null, ManagerRegistry $doctrine, Request $request): Response
    {
        $new = false;
        if(!$tache){
            $new = true;
            $tache = new Tache();
        }

        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            $manager = $doctrine->getManager();
            $manager->persist($tache);

            $manager->flush();

            if($new){
                $message = "La tache a été ajouter avec succès";
            }else{
                $message = "La tache a été editer avec succès";
            }

            $this->addFlash("succes", $message);

            return $this->redirectToRoute("mes_taches");
        }else{
            return $this->render('stagiaire/add_tache.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    #[Route('/details_tache/{id<\d+>}', name: 'details_tache')]
    public function details_tache(ManagerRegistry $doctrine, Tache $tache= null, $id): Response
    {
        if(!$tache){
            $this->addFlash('error', "Cette tache n'existe pas !");
            return $this->redirectToRoute("mes_taches");
        }
        return $this->render('stagiaire/tache_details.html.twig', ['tache' => $tache]);
    }

    #[Route('/delete_tache/{id?0}', name: 'delete_tache')]
    public function delete_tache(Tache $tache = null, ManagerRegistry $doctrine, Request $request, $id): Response
    {

        $repository = $doctrine->getRepository(Tache::class);
        $tache = $repository->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($tache);

        $manager->flush();

        $message = "La tache a été supprimer avec succès";


        $this->addFlash("succes", $message);

        return $this->redirectToRoute("mes_taches");

    }

}
