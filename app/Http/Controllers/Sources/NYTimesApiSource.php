<?php

namespace App\Http\Controllers\Sources;

class NYTimesApiSource extends HttpRequest
{
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = env("NYTIMESAPI_KEY");
    }

    public function getData(string $q = "election", int $limit = 30)
    {
        return $this->request("https://api.nytimes.com/svc/search/v2/articlesearch.json?api-key=".$this->apiKey."&q=".$q."&sort=relevance");
    }
}
