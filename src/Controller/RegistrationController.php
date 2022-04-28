<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration')]
    public function index(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /** @var $user User */
            $user = $form->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_USER']);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->renderForm('registration/index.html.twig',[
            'form' =>$form,
        ]);


    }
    #[Route('/passwordRetrieve', name: 'app_password_retrieve')]
    public function forgetPassword(){

    }
}
