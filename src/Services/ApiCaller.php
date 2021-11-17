<?php

namespace App\Services;

use App\Entity\Category;

class ApiCaller
{
    const CATEGORIES_ACCEPTED = ['business', 'health', 'entertainment', 'general', 'science', 'technology', 'sports'];
    private $apiKey;

    public function __construct (string $apiKey) {
        $this->apiKey = $apiKey;
    }

    public function getDataFromApi (Category $category) : ?array
    {
        if (!in_array($category->getName(), self::CATEGORIES_ACCEPTED)) {
            return null;
        }

        $url = 'https://newsapi.org/v2/top-headlines?country=fr&category=' . $category->getName() . '&pageSize=20&language=fr&apiKey='.$this->apiKey;
        $ressource = fopen($url, 'r');

        if (!is_resource($ressource)){
            return null;
        }

        $ressourceJSON = fgets($ressource);
        fclose($ressource);
        $data = json_decode($ressourceJSON, true);
        return $this->checkDataFromApi($data);
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

    private function getApiKey () {}
    private function setApiKey () {}
}