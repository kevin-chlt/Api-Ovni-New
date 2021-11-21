<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Category;
use App\Repository\ArticlesRepository;
use App\Services\ApiCaller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;


#[Route('/articles')]
class ArticlesController extends AbstractController
{
    #[Route('/{slug}', name: 'category_index')]
    public function index (ApiCaller $apiCaller, Category $category) : JsonResponse
    {
        $data = $apiCaller->getDataFromApi($category);

        if (!$data) {
            return $this->json('Un problème est apparu dans la reception, veuillez réessayer', 404);
        }

        return $this->json($category->getArticles());
    }

    #[Route('/{slug}/{article_id}', name: 'article_show')]
    #[Entity('articles', expr: 'repository.find(article_id)')]
    public function getArticle (ArticlesRepository $articlesRepository, Articles $articles) : JsonResponse
    {
        return $this->json($articles);
    }
}