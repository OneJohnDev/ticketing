<?php

namespace App\Form;

use App\Entity\EnumPriorite;
use App\Entity\EtatTicket;
use App\Entity\Ticket;
use App\Entity\User;
use App\Repository\EnumPrioriteRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('priorite', EntityType::class,[
                'label' => 'Priorité',
                'class'=>EnumPriorite::class,
                'choice_label' => 'Priorite'
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Créer le ticket'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
