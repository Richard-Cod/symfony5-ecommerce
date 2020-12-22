<?php

namespace App\Controller;


use App\Entity\Product;
use App\Classes\SearchCategory;
use App\Form\SearchCategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    private $entityManager;

    function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entityManager = $entitymanager;
    }

    /**
     * @Route("/produits", name="products")
     */
    public function index(Request $request): Response
    {

        $search = new SearchCategory();
        $form = $this->createForm(SearchCategoryType::class, $search);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Product::class)->findWithSearchCategory($search);


            // $this->entityManager->persist($user);
            // $this->entityManager->flush();
        } else {
            $products = $this->entityManager->getRepository(Product::class)->findAll();
        }


        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/produit/{slug}", name="product")
     */
    public function showBySlug($slug): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        if (!$product) {
            $this->redirectToRoute('products');
        }


        return $this->render('product/show.html.twig', [
            'product' => $product,
            'products' => $this->entityManager->getRepository(Product::class)->findAll(),

        ]);
    }

    // /**
    //  * @Route("/produit/seed", name="product")
    //  */
    // public function seedProducts($slug): Response
    // {
    //     $data = [
    //         [
    //             "name" => "Bonnet1", "subtitle" => "Sous titre",
    //             "description" => "Description du produit",
    //             "price" => 10.54,
    //         ],
    //     ];

    //     $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
    //     if (!$product) {
    //         $this->redirectToRoute('products');
    //     }

    //     return $this->render('product/show.html.twig', [
    //         'product' => $product,
    //         'products' => $this->entityManager->getRepository(Product::class)->findAll(),

    //     ]);
    // }


}
