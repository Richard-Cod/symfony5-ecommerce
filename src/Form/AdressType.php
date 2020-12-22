<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Quel nom souhaitez-vous donner à votre adresse ? *",
                'attr' => [
                    'placeholder' => "Nommez votre adresse Ex : Domicile , travail , etc ..."
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => "Votre prénom * ",
                'attr' => [
                    'placeholder' => "Entrer votre prénom "
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => "Votre nom *",
                'attr' => [
                    'placeholder' => "Entrer votre nom"
                ]
            ])
            ->add('compagny', TextType::class, [
                'label' => "Votre société ",
                'attr' => [
                    'placeholder' => "(facultatif) Entrez le nom de votre société"
                ]
            ])
            ->add('address', TextType::class, [
                'label' => "Votre adresse *",
                'attr' => [
                    'placeholder' => "54 rue des joubur ..."
                ]
            ])
            ->add('postal', TextType::class, [
                'label' => "Votre code postal *",
                'attr' => [
                    'placeholder' => "Entrer votre code postal"
                ]
            ])
            ->add('city', TextType::class, [
                'label' => "Ville *",
                'attr' => [
                    'placeholder' => "Entrer votre ville"
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => "Pays *",

            ])
            ->add('phone', TelType::class, [
                'label' => "Votre téléphone *",
                'attr' => [
                    'placeholder' => "Entrer votre numéro de téléphone"
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Soumettre",
                'attr' => [
                    'class' => 'btn btn-block btn-info'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
