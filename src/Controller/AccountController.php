<?php

namespace App\Controller;

use App\Form\UpdatePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    private $entityManager;

    function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entityManager = $entitymanager;
    }

    /**
     * @Route("/compte", name="account")
     */
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }


    /**
     * @Route("/compte/modifier-mot-de-passe", name="account.updatepassword")
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $notification = null;
        $user = $this->getUser();
        $form = $this->createForm(UpdatePasswordType::class, $user);

        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();


            $old_pwd = $form->get('old_password')->getData();
            $new_pwd = $form->get('new_password')->getData();

            if ($encoder->isPasswordValid($user, $old_pwd)) {
                $user->setPassword($encoder->encodePassword($user, $new_pwd));
                $this->entityManager->flush();
                $notification = "Mot de passe correctement mis à jour";
            } else {
                $notification = "Le mot de passe actuel n'est pas le bon";
            }
        }

        return $this->render('account/changepassword.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification,
        ]);
    }
}
