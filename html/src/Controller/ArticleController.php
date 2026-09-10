<?php

namespace App\Controller;

use App\Entity\ArticleArchive;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager->getRepository(ArticleArchive::class)->findAllSortedByDate();

        return $this->render('article/index.html.twig', [
            'title' => 'Articles',
            'articles' => $articles,
        ]);
    }
}
