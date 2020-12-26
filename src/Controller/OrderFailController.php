<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderFailController extends AbstractController
{
    /**
     * @Route("/commande/fail/{customer_session_id}", name="order_fail")
     */
    public function index($customer_session_id): Response
    {

        return $this->render('order_fail/index.html.twig', [
            'controller_name' => 'OrderFailController',
        ]);
    }
}
