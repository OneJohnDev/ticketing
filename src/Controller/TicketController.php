<?php

namespace App\Controller;

use App\Entity\EnumPriorite;
use App\Entity\EtatTicket;
use App\Entity\Message;
use App\Entity\Ticket;
use App\Entity\User;
use App\Form\MessageType;
use App\Form\TicketType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    #[Route('/new_ticket', name: 'app_ticket')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $ticket = new Ticket();
            //récupération de l'objet l'utilisateur
            $mail = $this->getUser()->getUserIdentifier();
            $user = $doctrine->getRepository(User::class)->findOneBy(['email'=>$mail]);
            $ticket->setUser($user);
            //récupération du formulaire(titre + description)
            $data = $form->getData();
            $ticket->setDescription($data->getDescription());
            $ticket->setTitre($data->getTitre());
            //récupération de l'heure
            $ticket->setDateCreation(new \DateTime(('now')));
            // récupération de l'objet ETAT
            $etat = $doctrine->getRepository(EtatTicket::class)->find(1);
            $ticket->setEtat($etat);
            // récupération de la priorité
            $priorite = $doctrine->getRepository(EnumPriorite::class)->findOneBy(['priorite'=>$data->getPriorite()->getPriorite()]);
            $ticket->setPriorite($priorite);
            $entityManager= $doctrine->getManager();
            $entityManager->persist($ticket);
            $entityManager->flush();
             return $this->redirectToRoute('app_homepage');
        }
        return $this->render('ticket/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/ticket/{id}', name: 'app_view_ticket')]
    public function viewTicket(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        /**
         * @var $message Message
         * @var $ticket Ticket
         */
        $ticket = $doctrine->getRepository(Ticket::class)->find($id);
        $etats = $doctrine->getRepository(EtatTicket::class)->findAll();
        $form = $this->createForm(MessageType::class);
        $form->handleRequest($request);
        if(isset($_GET['etat'])){
            $newEtat = $doctrine->getRepository(EtatTicket::class)->findOneBy(['state' => $_GET['etat']]);
            if($ticket->getEtat()->getState() != $newEtat->getState()){
                if($newEtat->getState()=="TERMINE"){
                    $ticket->setDateCloture(new \DateTime('NOW'));

                }
                $ticket->setEtat($newEtat);
                $entityManager = $doctrine->getManager();
                $entityManager->persist($ticket);
                $entityManager->flush();
            }
        }
        if($form->isSubmitted() && $form->isValid()){

            $message = $form->getData();
            $message->setDateEnvoie(new \DateTime('NOW'));
            $message->setTicket($ticket);
            $mail = $this->getUser()->getUserIdentifier();
            $user = $doctrine->getRepository(User::class)->findOneBy(['email'=>$mail]);
            $message->setExpediteur($user);
            $entityManager= $doctrine->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

        }
        return $this->renderForm('ticket/view.html.twig', [
            'ticket' => $ticket,
            'etats' => $etats,
            'form' => $form,
        ]);
    }
}
