<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\Validation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\DemandeType;
use App\Form\ValidationType;
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

    #[Route('/nos_demandes', name: 'nos_demandes')]
    public function nos_demandes(EntityManagerInterface $entityManager, Request $request): Response
    {
        $session = $request->getSession();

        $entreprise = $entityManager->getRepository(Entreprise::class)->findBy(["email" => $session->all()["_security.last_username"]]);

        $demandes = $entityManager->getRepository(Demande::class)->findBy([
            'entreprise' => $entreprise[0]->getId(),
            'etat' => 'En attente'
        ]);

        return $this->render('rh/nos_demandes.html.twig', ['demandes' => $demandes]);
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

            $demande->setEtat("En attente");

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

    #[Route('/valider_stage/{id?0}', name: 'valider_stage')]
    public function valider_stage(Validation $validation = null, ManagerRegistry $doctrine, Request $request, EntityManagerInterface $entityManager): Response
    {
        $new = false;
        if(!$validation){
            $new = true;
            $validation = new Validation();
        }

        $form = $this->createForm(ValidationType::class, $validation);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            $session = $request->getSession();

            $entreprise = $entityManager->getRepository(Entreprise::class)->findBy(["email" => $session->all()["_security.last_username"]]);
            $demande = $entityManager->getRepository(Demande::class)->findBy(["entreprise" => $entreprise[0]->getId()]);

            $demande[0]->setEtat("Validée");

            $date = new \DateTime();
            $validation->setDateValidation($date);

            $manager = $doctrine->getManager();

            $manager->persist($validation);
            $manager->persist($demande[0]);

            $manager->flush();

            if($new){
                $message = "La validation a été ajouter avec succès";
            }else{
                $message = "La validation a été editer avec succès";
            }

            $this->addFlash("succes", $message);

            return $this->redirectToRoute("nos_demandes");
        }else{
            return $this->render('rh/validation.html.twig', [
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

    #[Route('/delete_validation/{id?0}', name: 'delete_validation')]
    public function delete_validation(Validation $validation = null, ManagerRegistry $doctrine, Request $request, $id): Response
    {

        $repository = $doctrine->getRepository(Validation::class);
        $validation = $repository->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($validation);

        $manager->flush();

        $message = "La validation a été supprimer avec succès";


        $this->addFlash("succes", $message);

        return $this->redirectToRoute("nos_etudiants");

    }

    #[Route('/details_validation/{id<\d+>}', name: 'details_validation')]
    public function details_validation(ManagerRegistry $doctrine, Validation $validation= null, $id): Response
    {
        if(!$validation){
            $this->addFlash('error', "Cette validation n'existe pas !");
            return $this->redirectToRoute("mes_demandes");
        }
        return $this->render('rh/validation_details.html.twig', ['validation' => $validation]);
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
