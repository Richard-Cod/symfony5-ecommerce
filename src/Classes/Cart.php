<?php

namespace App\Classes;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private $session;
    private $entityManager;
    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    public function get()
    {
        return $this->session->get('cart', []);
    }
    public function getProductById($id)
    {
        $product_object = $this->entityManager->getRepository(Product::class)->findOneById($id);

        return $product_object;
    }

    public function getFull()
    {
        $cart = $this->get();

        $cartComplete = [];
        foreach ($cart as $id => $quantity) {
            $product_object = $this->getProductById($id);

            if ($product_object == null) {
                $this->delete($id);
                continue;
            }

            $cartComplete[] = [
                "product" => $product_object,
                "quantity" => $quantity
            ];
        }

        return $cartComplete;
    }

    public function add($id)
    {
        $cart = $this->get();

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            if ($this->getProductById($id) != null) {
                $cart[$id] = 1;
            }
        }
        $this->session->set('cart', $cart);
    }



    public function delete($id)
    {
        $cart = $this->get();
        unset($cart[$id]);
        $this->session->set('cart', $cart);
    }

    public function decrease($id)
    {
        $cart = $this->get();

        if ($cart[$id] >  1) {
            $cart[$id]--;
        } else {
            $this->delete($id);
        }
        $this->session->set('cart', $cart);
    }

    public function clear()
    {
        $this->session->remove('cart');
    }
}
