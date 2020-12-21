<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => "Prenom",
                'constraints' => [
                    new Length(['min' => 3]),
                ],

                'attr' => [
                    "placeholder" => "Saisir votre prenom "
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => "Nom",


                'attr' => [
                    "placeholder" => "Saisir votre nom "
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => "Email",
                'constraints' => new Email(),

                'attr' => [
                    "placeholder" => "Saisir votre mail "
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new Length(['min' => 5]),
                ],
                'required' => true,
                'invalid_message' => "Les mots de passe ne sont pas identiques",
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation du mot de passe'],

            ])
            ->add('Submit', SubmitType::class, [
                "label" => "S'inscrire"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
