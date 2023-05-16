<?php

namespace App\Http\Controllers\Sources;

use GuzzleHttp\Client;

class HttpRequest
{
    public function request(string $url)
    {
        try {
            $client = new Client();
            $res = $client->request(
                'GET',
                $url
            );
            return json_decode($res->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
