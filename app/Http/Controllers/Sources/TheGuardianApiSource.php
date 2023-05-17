<?php

namespace App\Http\Controllers\Sources;

class TheGuardianApiSource extends HttpRequest
{
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = env("THEGUARDIAN_API_KEY");
    }

    public function getData(string $q = "nba", int $limit = 30)
    {
        return $this->request("https://content.guardianapis.com/search?api-key=".$this->apiKey."&q=".$q);
    }
}
