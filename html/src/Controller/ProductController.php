<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $products = $entityManager->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', [
            'title' => 'Product',
            'products' => $products,
        ]);
    }

    #[Route('/product/add', name: 'app_product_add', methods: ['GET', 'POST'])]
    public function add_product(Request $request, EntityManagerInterface $entityManager): Response
    {
        $title = "Add new product";
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product, ['form_title' => $title]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'Product added with success!');

            return $this->redirectToRoute('app_product');
        }

        return $this->render('product/add_product.html.twig', [
            'title' => $title,
            'form' => $form->createView(),
        ]);
    }
}
