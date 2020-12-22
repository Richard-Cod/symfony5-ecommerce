<?php

namespace App\Controller;

use App\Classes\Cart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/mon-panier", name="cart")
     */
    public function index(Cart $cart): Response
    {
        $items = $cart->getFull();
        return $this->render('cart/index.html.twig', [
            'items' => $items,
        ]);
    }

    /**
     * @Route("/mon-panier/add/{id}", name="cart.add")
     */
    public function add(Cart $cart, $id): Response
    {
        $cart->add($id);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/mon-panier/clear", name="cart.clear")
     */
    public function clear(): Response
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/mon-panier/delete/{id}", name="cart.delete")
     */
    public function delete(Cart $cart, $id): Response
    {
        $cart->delete($id);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/mon-panier/decrease/{id}", name="cart.decrease")
     */
    public function decrease(Cart $cart, $id): Response
    {
        $cart->decrease($id);

        return $this->redirectToRoute('cart');
    }
}
