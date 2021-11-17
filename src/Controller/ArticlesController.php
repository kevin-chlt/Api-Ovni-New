<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Category;
use App\Services\ApiCaller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/articles')]
class ArticlesController extends AbstractController
{
    #[Route('/{name}', name: 'category_index')]
    public function index (ApiCaller $apiCaller, Category $category, EntityManagerInterface $entityManager) : JsonResponse
    {
        $data = $apiCaller->getDataFromApi($category);

        if ($data === null) {
            return $this->json('Un problème est apparu dans la reception, veuillez réessayer', 404);
        }

        foreach ($data as $article) {
            $articles = (new Articles())
                ->setDescription($article['description'])
                ->setExternalLink($article['url'])
                ->setTitle($article['title'])
                ->setUrlToImage($article['urlToImage']);


            if($article['publishedAt'] !== null) {
                $articles->setPublishedAt(new \DateTime($article['publishedAt']));
            }

            $entityManager->persist($articles);
            $entityManager->flush();
        }
        return $this->json($data);
    }
}