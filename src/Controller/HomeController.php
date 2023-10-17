<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistrationFormType;
use App\Entity\Entreprise;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(Entreprise $entreprise = null, ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $new = false;
        if(!$entreprise){
            $new = true;
            $entreprise = new Entreprise();
        }

        $registrationForm = $this->createForm(RegistrationFormType::class, $entreprise);

        //dd($request->request);
        $registrationForm->handleRequest($request);

        if($registrationForm->isSubmitted()){

            //dd($request->request);
            $entreprise->setPassword(
                $userPasswordHasher->hashPassword(
                    $entreprise,
                    $registrationForm->get('password')->getData()
                )
            );

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
                'registrationForm' => $registrationForm->createView()
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

    #[Route('/login_', name: 'login')]
    public function login(): Response
    {
        return $this->render('login.html.twig');
    }
}
