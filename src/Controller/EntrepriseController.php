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
}
