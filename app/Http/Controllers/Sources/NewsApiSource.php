<?php

namespace App\Http\Controllers\Sources;

class NewsApiSource extends HttpRequest
{
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = env("NEWSAPI_API_KEY");
    }

    public function getData(string $q = "bitcoin", int $limit = 30)
    {
        return $this->request("https://newsapi.org/v2/everything?apiKey=".$this->apiKey."&q=".$q."&pageSize=".$limit."&language=en");
    }
}
