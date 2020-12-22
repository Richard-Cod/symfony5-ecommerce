<?php

namespace App\Form;

use App\Entity\User;
use App\Classes\SearchCategory;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class SearchCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('string', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new Length(['min' => 3]),
                ],
                'attr' => [
                    "placeholder" => "Rechercher ... "
                ]
            ])
            ->add('categories', EntityType::class, [
                'label' => false,
                'class' => Category::class,
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    "placeholder" => "Rechercher ... "
                ]
            ])
            ->add('Submit', SubmitType::class, [
                "label" => "Filtrer par categorie",
                'attr' => [
                    "class" => "btn-sm btn-danger"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchCategory::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
