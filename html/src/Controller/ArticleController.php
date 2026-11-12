<?php

namespace App\Controller;

use App\Entity\ArticleArchive;
use App\Form\ArticleFilterType;
use App\Repository\ArticleArchiveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    #[Route('/article/{id}/visibility', name: 'app_article_visibility', methods: ['POST'])]
    public function toggleVisibility(ArticleArchive $article, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $payload = $request->getPayload();

        if (!$this->isCsrfTokenValid('article-visibility', $payload->getString('_token'))) {
            return $this->json(['error' => 'Invalid CSRF token.'], Response::HTTP_FORBIDDEN);
        }

        $article->setIsVisible($payload->getBoolean('isVisible'));
        $entityManager->flush();

        return $this->json([
            'id' => $article->getId(),
            'isVisible' => $article->isVisible(),
        ]);
    }
}
