<?php

namespace App\Services;


class ApiCaller
{
    const CATEGORIES = ['business', 'health', 'entertainment', 'general', 'science', 'technology', 'sports'];

    public function getDataFromApi (string $category) : ?array
    {
        if (!in_array($category, self::CATEGORIES)) {
            return null;
        }

        $url = 'https://newsapi.org/v2/top-headlines?country=fr&category=' . $category . '&pageSize=20&language=fr&apiKey='.$_SERVER['NEWS_API_KEY'];
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

}