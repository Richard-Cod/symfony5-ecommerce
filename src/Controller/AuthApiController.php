<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthApiController extends AbstractController
{
    private $entityManager;

    function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entityManager = $entitymanager;
    }
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {

        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $roles = $request->request->get('roles');

        if (!$roles) {
            $roles = json_encode([]);
        }

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($encoder->encodePassword($user, $password));
        $user->setRoles(($roles));

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return new Response(sprintf('User %s successfully created', $user->getEmail()));
    }
}
