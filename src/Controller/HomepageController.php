<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(ManagerRegistry $doctrine): Response
    {
        /*        if(!$this->isGranted('ROLE_USER')){
                    dd("N'a pas le rôle je redirige");
                }*/
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $role = $this->getUser()->getRoles();

        //récupération des tickets + déclarations des tableaux
        $ticketsNonAttribues = array();
        $ticketsAttribues = array();
        $ticketsEnCours = array();
        $ticketsEnAttentes = array();
        $ticketsTermines = array();
        $mail = $this->getUser()->getUserIdentifier();
        $user = $doctrine->getRepository(User::class)->findOneBy(['email' => $mail]);
        $tickets = $doctrine->getRepository(Ticket::class)->findAll();
        if(!$this->isGranted('ROLE_ADMIN')) {
            foreach ($tickets as $ticket) {
                if ($ticket->getEtat()->getId() == 1 && $ticket->getUser()==$user) {
                    $ticketsNonAttribues[] = $ticket;
                }elseif($ticket->getEtat()->getId() == 2 && $ticket->getUser()==$user){
                    $ticketsAttribues[]= $ticket;
                }elseif($ticket->getEtat()->getId() == 3 && $ticket->getUser()==$user){
                    $ticketsEnCours[]= $ticket;
                }elseif($ticket->getEtat()->getId() == 4 && $ticket->getUser()==$user){
                    $ticketsEnAttentes[]= $ticket;
                }elseif($ticket->getEtat()->getId() == 5 && $ticket->getUser()==$user){
                    $ticketsTermines[]= $ticket;
                }else $error="";
            }

        }else{
            foreach ($tickets as $ticket) {
                if ($ticket->getEtat()->getId() == 1) {
                    $ticketsNonAttribues[] = $ticket;
                } else if ($ticket->getEtat()->getId() == 2) {
                    $ticketsAttribues[] = $ticket;
                } else if ($ticket->getEtat()->getId() == 3) {
                    $ticketsEnCours[] = $ticket;
                } else if ($ticket->getEtat()->getId() == 4) {
                    $ticketsEnAttentes[] = $ticket;
                } else {
                    $ticketsTermines[] = $ticket;
                }
            }
        }

            return $this->render('homepage/index.html.twig', [
                'role' => $role,
                'user' => $this->getUser(),
                'nonAttribues' => $ticketsNonAttribues,
                'attribues' => $ticketsAttribues,
                'enCours' => $ticketsEnCours,
                'enAttente' => $ticketsEnAttentes,
                'termines' => $ticketsTermines,
            ]);
        }
    }
