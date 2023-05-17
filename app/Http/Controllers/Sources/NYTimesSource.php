<?php

namespace App\Http\Controllers\Sources;

class NYTimesSource extends HttpRequest
{
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = env("NYTIMES_API_KEY");
    }

    public function getData(string $q = "election", int $limit = 30)
    {
        return $this->request("https://api.nytimes.com/svc/search/v2/articlesearch.json?api-key=".$this->apiKey."&q=".$q."&sort=relevance");
    }
}
