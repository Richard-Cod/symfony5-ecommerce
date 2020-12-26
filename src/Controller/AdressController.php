<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Adress;
use App\Form\AdressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdressController extends AbstractController
{
    private $entityManager;

    function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entityManager = $entitymanager;
    }

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
            $adress->setUser($this->getUser());

            $this->entityManager->persist($adress);
            $this->entityManager->flush();
            return $this->redirectToRoute('account.adress');
        }

        return $this->render('account/adress_add.html.twig', [
            'form' => $form->createView(),
            'type' => "Créer"
        ]);
    }

    /**
     * @Route("/compte/adress/edit/{id}", name="account.adress.edit")
     */
    public function edit(Request $request, $id): Response
    {
        $adress = $this->entityManager->getRepository(Adress::class)->findOneById($id);


        if (!$adress || $adress->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account.adress');
        }


        $form = $this->createForm(AdressType::class, $adress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adress = $form->getData();
            $this->entityManager->flush();
            return $this->redirectToRoute('account.adress');
        }

        return $this->render('account/adress_add.html.twig', [
            'form' => $form->createView(),
            'type' => "Créer"
        ]);
    }


    /**
     * @Route("/compte/adress/delete/{id}", name="account.adress.delete")
     */
    public function delete(Request $request, $id): Response
    {
        $adress = $this->entityManager->getRepository(Adress::class)->findOneById($id);
        if ($adress && $adress->getUser() && $this->getUser()) {
            $this->entityManager->remove($adress);
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('account.adress');
    }
}
