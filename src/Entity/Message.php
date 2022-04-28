<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text', nullable: true)]
    private $message;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'messages')]
    private $Expediteur;

    #[ORM\Column(type: 'datetime')]
    private $date_envoie;

    #[ORM\ManyToOne(targetEntity: Ticket::class, inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private $ticket;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getExpediteur(): ?User
    {
        return $this->Expediteur;
    }

    public function setExpediteur(?User $Expediteur): self
    {
        $this->Expediteur = $Expediteur;

        return $this;
    }

    public function getDateEnvoie(): ?\DateTimeInterface
    {
        return $this->date_envoie;
    }

    public function setDateEnvoie(\DateTimeInterface $date_envoie): self
    {
        $this->date_envoie = $date_envoie;

        return $this;
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(?Ticket $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }
}
