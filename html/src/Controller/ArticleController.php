<?php

namespace App\Controller;

use App\Form\ArticleFilterType;
use App\Repository\ArticleArchiveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(Request $request, ArticleArchiveRepository $repository): Response
    {
        $articleFilterForm = $this->createForm(ArticleFilterType::class);
        $articleFilterForm->handleRequest($request);

        $title = null;
        $showHidden = false;

        if ($articleFilterForm->isSubmitted() && $articleFilterForm->isValid()) {
            $data = $articleFilterForm->getData();
            $title = $data['title'];
            $showHidden = (bool) $data['showHidden'];
        }

        return $this->render('article/index.html.twig', [
            'title' => 'Articles',
            'articleFilterForm' => $articleFilterForm,
            'articles' => $repository->findByFilters($title, $showHidden),
        ]);
    }
}
