<?php

namespace App\Controller;

use App\Entity\ArticleArchive;

use App\Form\ArticleFilterType;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $articleArchive = new ArticleArchive();
        $articleFilterForm = $this->createForm(ArticleFilterType::class, $articleArchive);
        $articleFilterForm->handleRequest($request);

        if ($articleFilterForm->isSubmitted() && $articleFilterForm->isValid()) {

        }

        $articles = $entityManager->getRepository(ArticleArchive::class)->findAllSortedByDate();


        return $this->render('article/index.html.twig', [
            'title' => 'Articles',
            'articleFilterForm' => $articleFilterForm,
            'articles' => $articles,
        ]);
    }
}
