<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Entreprise;
use Doctrine\ORM\EntityManagerInterface;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprises', name: 'entreprises')]
    public function entreprises(EntityManagerInterface $entityManager): Response
    {
        $entreprises = $entityManager->getRepository(Entreprise::class)->findAll();

        return $this->render('admin/entreprises.html.twig', ['entreprises' => $entreprises]);
    }


    #[Route('/detail_entreprise/{id<\d+>}', name: 'detail_entreprise')]
    public function detail_entreprise(ManagerRegistry $doctrine, Entreprise $entreprise= null, $id): Response
    {
        if(!$entreprise){
            $this->addFlash('error', "Cet entreprise n'existe pas !");
            return $this->redirectToRoute("entreprises");
        }
        return $this->render('admin/entreprise_details.html.twig', ['entreprise' => $entreprise]);
    }

    #[Route('/delete_entreprise/{id?0}', name: 'delete_entreprise')]
    public function delete_entreprise(Entreprise $entreprise = null, ManagerRegistry $doctrine, Request $request, $id): Response
    {

        $repository = $doctrine->getRepository(Entreprise::class);
        $entreprise = $repository->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($entreprise);

        $manager->flush();

        $message = "L'entreprise a été supprimer avec succès";


        $this->addFlash("succes", $message);

        return $this->redirectToRoute("entreprises");

    }
}
