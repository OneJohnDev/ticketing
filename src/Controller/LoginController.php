<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine, AuthenticationUtils $authenticationUtils): Response
    {
        if($this->getUser()){
            return $this->redirectToRoute('app_homepage');
        }
        $form = $this->createForm(LoginType::class);
        //nécessaire?
        $form->handleRequest($request);


        return $this->renderForm('login/index.html.twig', [
            'form' => $form,

        ]);
    }
}
