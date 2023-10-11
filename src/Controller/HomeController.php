<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EntrepriseType;
use App\Entity\Entreprise;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(Entreprise $entreprise = null, ManagerRegistry $doctrine, Request $request): Response
    {
        $new = false;
        if(!$entreprise){
            $new = true;
            $entreprise = new Entreprise();
        }

        $form = $this->createForm(EntrepriseType::class, $entreprise);

        //dd($request->request);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            $manager = $doctrine->getManager();
            $manager->persist($entreprise);
                
            $manager->flush();

            if($new){
                $message = "L'entreprise a été ajouter avec succès";
            }else{
                $message = "L'entreprise a été editer avec succès";
            }

            $this->addFlash("succes", $message);

            return $this->redirectToRoute("app_home");
        }else{
            return $this->render('home/index.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }


    #[Route('/coordonateur', name: 'coordonateur')]
    public function coordonateur(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/rh', name: 'rh')]
    public function rh(): Response
    {
        return $this->render('rh/index.html.twig');
    }

    #[Route('/stagiaire', name: 'stagiaire')]
    public function stagiaire(): Response
    {
        return $this->render('stagiaire/index.html.twig');
    }

    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('login.html.twig');
    }
}
