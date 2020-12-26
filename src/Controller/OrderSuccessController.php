<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderSuccessController extends AbstractController
{
    /**
     * @Route("/commande/success/{stripeSessionId}", name="order_success")
     */
    public function index(EntityManagerInterface $em, $stripeSessionId): Response
    {


        return $this->render('order_success/index.html.twig', [
            'controller_name' => 'OrderSuccessController',
        ]);
    }
}
