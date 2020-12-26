<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Adress;
use App\Entity\Carrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $user = $options['user'];
        $builder
            ->add('adress', EntityType::class, [
                'label' => "Choisissez votre adresse de livraison",
                'class' => Adress::class,
                'choices' => $user->getAdresses(),

            ])
            ->add('carrier', EntityType::class, [
                'label' => "Choisissez votre transporteur",
                'class' => Carrier::class,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            "user" => User::class,
        ]);
    }
}
