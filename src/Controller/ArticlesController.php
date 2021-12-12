<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArticlesRepository;
use App\Services\ApiCaller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/articles')]
class ArticlesController extends AbstractController
{
    #[Route('/category/{slug}', name: 'category_index')]
    public function index (ApiCaller $apiCaller, Category $category, ArticlesRepository $articlesRepository) : JsonResponse
    {
        $data = $apiCaller->getDataFromApi($category);

        if (!$data) {
            return $this->json('Un problème est apparu dans la reception, veuillez réessayer', 404);
        }

        return $this->json($articlesRepository->findArticleByCategory($category));
    }

    #[Route('/ids', name: 'get_all_article_ID')]
    public function getAllId (ArticlesRepository $articlesRepository) : JsonResponse
    {
        return $this->json($articlesRepository->getAllId());
    }

}

