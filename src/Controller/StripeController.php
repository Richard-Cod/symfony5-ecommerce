<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Classes\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\HttpFoundation\JsonResponse;


class StripeController extends AbstractController
{
    /**
     * @Route("/stripe/{reference}", name="stripe")
     */
    public function index(EntityManagerInterface $em, Cart $cart, $reference)
    {

        $order = $em->getRepository(Order::class)->findOneByReference($reference);


        if (!$order || $order->getUser() != $this->getUser()) {
            return new JsonResponse(["error" => "Order"]);
        }


        $YOUR_DOMAIN = 'http://127.0.0.1:8000';

        $products_for_stripe = [];
        foreach ($cart->getFull() as $item) {
            $product = $item['product'];
            $quantity = $item['quantity'];
            $products_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getPrice(),
                    'product_data' => [
                        'name' => $product->getName(),
                        'images' => [$YOUR_DOMAIN . '/uploads/' . $product->getIllustration()],
                    ],
                ],
                'quantity' => $quantity,
            ];
        }

        $apiKey = "sk_test_51HoS5CJk6zjYQ0dcGzoiHpNpiceycY5OtwX3BNEyA8DCRHI1qkEBpusWR2CHtVMeTmUVmQHuT4FSAjOGm7sJrSDU00iNNDvsup";
        Stripe::setApiKey($apiKey);
        header('Content-Type: application/json');


        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => $products_for_stripe,
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commande/success' . '/{CHECKOUT_SESSION_ID}',
            'cancel_url' =>  $YOUR_DOMAIN . '/commande/fail' . '/{CHECKOUT_SESSION_ID}',

        ]);


        // $success_path = $this->generateUrl('order_success',array(['customerSessionId' => ]));
        // $fail_path = $this->generateUrl('order_fail');


        $response = new JsonResponse($checkout_session);
        return $response;
    }
}
