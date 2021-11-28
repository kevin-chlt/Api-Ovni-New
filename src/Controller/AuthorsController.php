<?php

namespace App\Controller;

use App\Entity\Authors;
use App\Repository\AuthorsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/authors')]
class AuthorsController extends AbstractController
{
    #[Route('/', name: 'authors_list')]
    public function getAllAuthors (AuthorsRepository $authorsRepository) : JsonResponse
    {
        return $this->json($authorsRepository->findAll());
    }

    #[Route('/{id}', name: 'articles_from_authors')]
    public function getArticlesByAuthor (Authors $author) : JsonResponse
    {
        return $this->json($author->getArticles());
    }
}