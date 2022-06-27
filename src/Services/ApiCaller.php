<?php

namespace App\Services;

use App\Entity\Articles;
use App\Entity\Authors;
use App\Entity\Category;
use App\Repository\ArticlesRepository;
use App\Repository\AuthorsRepository;
use Doctrine\ORM\EntityManagerInterface;

class ApiCaller
{
    const CATEGORIES_ACCEPTED = ['business', 'health', 'entertainment', 'general', 'science', 'technology', 'sports'];
    private $apiKey;
    private $entityManager;
    private $authorsRepository;
    private $articleRepository;

    public function __construct (string $apiKey, AuthorsRepository $authorsRepository, EntityManagerInterface $entityManager, ArticlesRepository $articleRepository) {
        $this->apiKey = $apiKey;
        $this->authorsRepository = $authorsRepository;
        $this->entityManager = $entityManager;
        $this->articleRepository = $articleRepository;
    }

    public function getDataFromApi (Category $category) : bool
    {

        if (!in_array($category->getSlug(), self::CATEGORIES_ACCEPTED)) {
            return false;
        }

        $url = 'https://newsapi.org/v2/top-headlines?country=fr&category=' . $category->getSlug() . '&apiKey='.$this->apiKey;
        $ressource = fopen($url, 'r');

        if (!is_resource($ressource)){
            return false;
        }

        $ressourceJSON = fgets($ressource);
        fclose($ressource);
        $data = json_decode($ressourceJSON, true);

        $dataFiltered = $this->checkDataFromApi($data);
        $this->addArticleInDB($dataFiltered,$category);

        return true;
    }


    private function checkDataFromApi (array $data) : array
    {
        $dataFiltered = [];
        for ($i = 0 ; $i < count($data['articles']); $i++){
            if(isset($data['articles'][$i]['urlToImage']) && isset($data['articles'][$i]['title']) && isset($data['articles'][$i]['url'])){
                $dataFiltered[] = $data['articles'][$i];
            }
        }

        return $dataFiltered;
    }


    private function addArticleInDB (array $data, Category $category) : void
    {
        foreach ($data as $article) {
            $articleInDb = $this->articleRepository->findOneBy(['title' => $article['title']]);
            if ($articleInDb !== null) {
                continue;
            }

            $newArticles = (new Articles())
                ->setDescription($article['description'])
                ->setExternalLink($article['url'])
                ->setTitle($article['title'])
                ->setUrlToImage($article['urlToImage'])
                ->addCategory($category);

            $authorInDb = $this->authorsRepository->findOneBy(['name' => $article['source']['name']]);

            if( $authorInDb === null){
                $newAuthor = (new Authors())->setName($article['source']['name']);
                $newArticles->addAuthor($newAuthor);
            } else {
                $newArticles->addAuthor($authorInDb);
            }

            if($article['publishedAt'] !== null) {
                $newArticles->setPublishedAt(new \DateTime($article['publishedAt']));
            }

            $this->entityManager->persist($newArticles);
            $this->entityManager->flush();
        }
    }
}