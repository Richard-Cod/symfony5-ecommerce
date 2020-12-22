<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Entity\User;
use App\Form\AdressType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdressController extends AbstractController
{
    /**
     * @Route("/compte/adress", name="account.adress")
     */
    public function index(): Response
    {
        return $this->render('account/adress.html.twig', [
            'controller_name' => 'AdressController',
        ]);
    }


    /**
     * @Route("/compte/adress/add", name="account.adress.add")
     */
    public function add(Request $request): Response
    {

        $adress = new Adress();
        $form = $this->createForm(AdressType::class, $adress);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adress = $form->getData();
            dd($adress);

            // $this->entityManager->persist($user);
            // $this->entityManager->flush();
        }

        return $this->render('account/adress_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
