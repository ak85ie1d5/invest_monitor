<?php

namespace App\Controller;

use App\Entity\Wallet;
use App\Form\WalletRowType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WalletController extends AbstractController
{
    #[Route('/wallet', name: 'app_wallet')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $walletRows = $entityManager->getRepository(Wallet::class)->findAll();

        return $this->render('wallet/index.html.twig', [
            'title' => 'Porte-feuille',
            'walletRows' => $walletRows,
        ]);
    }

    #[Route('/wallet/add-product', name: 'app_wallet_add_product', methods: ['GET', 'POST'])]
    public function addProduct(Request $request, EntityManagerInterface $entityManager): Response
    {
        $wallet = new Wallet();
        $form = $this->createForm(WalletRowType::class, $wallet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($wallet);
            $entityManager->flush();

            $this->addFlash('success', 'Produit ajouté au portefeuille.');

            return $this->redirectToRoute('app_wallet');
        }

        return $this->render('wallet/add_product.html.twig', [
            'title' => "Ajouter un produit",
            'form' => $form->createView()
        ]);
    }
}
