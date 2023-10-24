<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EntrepriseType;
use App\Entity\Entreprise;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use function Monolog\Formatter\format;


class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(Entreprise $entreprise = null, ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $userPasswordHasher, SluggerInterface $slugger): Response
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

            $user = new User();

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $image = $form->get('logo')->getData();

            if ($image) {

                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $entreprise->setLogo($newFilename);
                $user->setLogo($newFilename);
                $user->setNom($form->get('nom_entreprise')->getData());
            }

            $user->setEmail($form->get('email')->getData());

            $entreprise->setPassword($user->getPassword());
            $entreprise->setEtatEntreprise("En attente");

            $dateD = new \DateTime();
            $date = $dateD->format('Y-m-d');

            $entreprise->setDateCreation($date);

            $manager = $doctrine->getManager();
            $manager->persist($entreprise);
            $manager->persist($user);
                
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

    #[Route('/redirection', name: 'redirection')]
    public function redirection(EntityManagerInterface $entityManager, Request $request): Response
    {
        $session = $request->getSession();

        $user = $entityManager->getRepository(Entreprise::class)->findBy([
            "email" => $session->all()["_security.last_username"],
        ]);

        $user2 = $entityManager->getRepository(Etudiant::class)->findBy(["email" => $session->all()["_security.last_username"]]);

        $user3 = $entityManager->getRepository(User::class)->findBy(["email" => $session->all()["_security.last_username"]]);

        if ($user){
            if ($user[0]->getEtatEntreprise() == "Partenaire"){
                return $this->redirectToRoute("rh");
            }else{
                return $this->redirectToRoute("app_home");
            }
        }else if ($user2){
            return $this->redirectToRoute("stagiaire");
        }else if ($user3){
            return $this->redirectToRoute("coordonateur");
        }else {
            return $this->redirectToRoute("app_home");
        }

        if ($user3){
            return $this->redirectToRoute("coordonateur");
        }
    }
}
