<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EtudiantType;
use App\Entity\Etudiant;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;


class EtudiantController extends AbstractController
{
    
    #[Route('/etudiants', name: 'etudiants')]
    public function etudiants(EntityManagerInterface $entityManager): Response
    {
        $etudiants = $entityManager->getRepository(Etudiant::class)->findAll();

        return $this->render('admin/etudiants.html.twig', ['etudiants' => $etudiants]);
    }

    #[Route('/editer_etudiant/{id?0}', name: 'editer_etudiant')]
    public function editer_etudiant(Etudiant $etudiant = null, ManagerRegistry $doctrine, Request $request): Response
    {
        $new = false;
        if(!$etudiant){
            $new = true;
            $etudiant = new Etudiant();
        }

        $form = $this->createForm(EtudiantType::class, $etudiant);
        //dd($request->request);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            $manager = $doctrine->getManager();
            $manager->persist($etudiant);

            $manager->flush();

            if($new){
                $message = "L'etudiant a été ajouter avec succès";
            }else{
                $message = "L'etudiant a été editer avec succès";
            }

            $this->addFlash("succes", $message);

            return $this->redirectToRoute("etudiants");
        }else{
            return $this->render('admin/add_etudiant.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

}
