<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UpdatePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => "Prenom",
                'disabled' => true,
            ])
            ->add('lastname', TextType::class, [
                'label' => "Nom",
                'disabled' => true,

            ])
            ->add('email', EmailType::class, [
                'label' => "Email",
                'disabled' => true,

            ])
            ->add('old_password', PasswordType::class, [
                'label' => "Mot de passe actuel",
                'mapped' => false,
                'attr' => [
                    'placeholder' => "Taper votre mot de passe actuel"
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'constraints' => [
                    new Length(['min' => 5]),
                ],
                'required' => true,
                'invalid_message' => "Les mots de passe ne sont pas identiques",
                'first_options'  => ['label' => 'Mot de passe', 'attr' => ["placeholder" => "Taper le nouveau mot de passe"]],
                'second_options' => ['label' => 'Confirmation du mot de passe', 'attr' => ["placeholder" => "Confirmer le nouveau mot de passe"]],

            ])
            ->add('Submit', SubmitType::class, [
                "label" => "Mettre à jour le mot de passe"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
