<?php

namespace App\Controller;

use DateTime;
use Stripe\Stripe;
use App\Classes\Cart;
use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\OrderDetail;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Date;

class OrderController extends AbstractController
{
    private $entityManager;

    function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entityManager = $entitymanager;
    }

    /**
     * @Route("/commande", name="order")
     */
    public function index(Request $request, Cart $cart): Response
    {
        $form = $this->createForm(OrderType::class, null, [
            "user" => $this->getUser(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);
    }

    /**
     * @Route("/commande/ajout", name="order.add")
     */
    public function add(Request $request, Cart $cart): Response
    {
        $form = $this->createForm(OrderType::class, null, [
            "user" => $this->getUser(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $order = new Order();

            $carrier = $data['carrier'];
            $adress = $data['adress'];

            //Order 
            $order->setUser($this->getUser());
            $order->setCreatedAt(new DateTime());
            $order->setCarrierName($carrier->getName());
            $order->setCarrierPrice($carrier->getPrice());

            $deliveryAdd  = $adress->getName() . '<br/>';
            $deliveryAdd .= $adress->getPostal() . '<br/>';

            if ($adress->getCompagny()) {
                $deliveryAdd .= $adress->getCompagny() . '<br/>';
            }
            $deliveryAdd .= $adress->getAddress() . '<br/>';
            $deliveryAdd .= $adress->getCity() . '<br/>';
            $deliveryAdd .= $adress->getCountry() . '<br/>';
            $deliveryAdd .= $adress->getPhone() . '';

            $order->setAdress($deliveryAdd);
            $order->setIsPaid(false);

            $ref = new DateTime();
            $ref = $ref->format('dmY') . '_' . uniqid();
            $order->setReference($ref);

            $this->entityManager->persist($order);

            foreach ($cart->getFull() as $item) {

                $orderDetail = new OrderDetail();
                $product = $item['product'];
                $quantity = $item['quantity'];
                $orderDetail->setTheOrder($order);
                $orderDetail->setProduct($product->getName());
                $orderDetail->setQuantity($quantity);
                $orderDetail->setPrice($product->getPrice());
                $orderDetail->setTotal($product->getPrice() * $quantity);
                $this->entityManager->persist($orderDetail);
            }


            $this->entityManager->flush();

            return $this->render('order/add.html.twig', [
                'cart' => $cart->getFull(),
                'order' => $order,
                'carrier' => $carrier,
                'reference' => $ref,
            ]);
        }

        return $this->redirectToRoute('order');
    }
}
