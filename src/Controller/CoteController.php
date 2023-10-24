<?php

namespace App\Controller;

use App\Entity\Cote;
use App\Entity\Entreprise;
use App\Form\CoteType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoteController extends AbstractController
{
    #[Route('/cotes', name: 'cotes')]
    public function mes_cotes(EntityManagerInterface $entityManager, Request $request): Response
    {
        $session = $request->getSession();
        $entreprise = $entityManager->getRepository(Entreprise::class)->findBy(["email" => $session->all()["_security.last_username"]]);
        $cotes = $entityManager->getRepository(Cote::class)->findBy(["entreprise" => $entreprise]);

        return $this->render('rh/cotes.html.twig', ['cotes' => $cotes]);
    }

    #[Route('/les_cotes', name: 'les_cotes')]
    public function les_cotes(EntityManagerInterface $entityManager): Response
    {
        $cotes = $entityManager->getRepository(Cote::class)->findBy(["provenance" => 'Entreprise']);

        return $this->render('admin/cotes.html.twig', ['cotes' => $cotes]);
    }

    #[Route('/nos_cotes', name: 'nos_cotes')]
    public function nos_cotes(EntityManagerInterface $entityManager): Response
    {
        $cotes = $entityManager->getRepository(Cote::class)->findBy(["provenance" => 'ESIS']);

        return $this->render('admin/cotes.html.twig', ['cotes' => $cotes]);
    }

    #[Route('/editer_cote/{id?0}', name: 'editer_cote')]
    public function editer_cote(Cote $cote = null, ManagerRegistry $doctrine, Request $request): Response
    {
        $new = false;
        if(!$cote){
            $new = true;
            $cote = new Cote();
        }

        $form = $this->createForm(CoteType::class, $cote);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            $manager = $doctrine->getManager();
            $manager->persist($cote);

            $manager->flush();

            if($new){
                $message = "La cote a été ajouter avec succès";
            }else{
                $message = "La cote a été editer avec succès";
            }

            $this->addFlash("succes", $message);

            return $this->redirectToRoute("cotes");
        }else{
            return $this->render('rh/add_cote.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    #[Route('/edite_cote/{id?0}', name: 'edite_cote')]
    public function edite_cote(Cote $cote = null, ManagerRegistry $doctrine, Request $request): Response
    {
        $new = false;
        if(!$cote){
            $new = true;
            $cote = new Cote();
        }

        $form = $this->createForm(CoteType::class, $cote);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            $manager = $doctrine->getManager();
            $manager->persist($cote);

            $manager->flush();

            if($new){
                $message = "La cote a été ajouter avec succès";
            }else{
                $message = "La cote a été editer avec succès";
            }

            $this->addFlash("succes", $message);

            return $this->redirectToRoute("nos_cotes");
        }else{
            return $this->render('admin/add_cote.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    #[Route('/details_cote/{id<\d+>}', name: 'details_cote')]
    public function details_cote(ManagerRegistry $doctrine, Cote $cote= null, $id): Response
    {
        if(!$cote){
            $this->addFlash('error', "Cette cote n'existe pas !");
            return $this->redirectToRoute("cotes");
        }
        return $this->render('rh/cote_details.html.twig', ['cote' => $cote]);
    }

    #[Route('/detail_cote/{id<\d+>}', name: 'detail_cote')]
    public function detail_cote(ManagerRegistry $doctrine, Cote $cote= null, $id): Response
    {
        if(!$cote){
            $this->addFlash('error', "Cette cote n'existe pas !");
            return $this->redirectToRoute("cotes");
        }
        return $this->render('admin/cote_details.html.twig', ['cote' => $cote]);
    }


    #[Route('/delete_cote/{id?0}', name: 'delete_cote')]
    public function delete_cote(Cote $cote = null, ManagerRegistry $doctrine, Request $request, $id): Response
    {

        $repository = $doctrine->getRepository(Cote::class);
        $cote = $repository->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($cote);

        $manager->flush();

        $message = "La cote a été supprimer avec succès";


        $this->addFlash("succes", $message);

        return $this->redirectToRoute("cotes");

    }

}
