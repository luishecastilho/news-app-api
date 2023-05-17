<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Article;

use App\Http\Controllers\Sources\{
    NewsApiSource,
    NYTimesSource,
    TheGuardianApiSource
};

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataNewsApi = array();
        $dataNewsApi["bitcoin"][] = (new NewsApiSource())->getData("bitcoin", 10)["articles"];
        $dataNewsApi["berlin"][] = (new NewsApiSource())->getData("berlin", 10)["articles"];
        $dataNewsApi["cars"][] = (new NewsApiSource())->getData("cars", 10)["articles"];
        // 30 articles

        foreach($dataNewsApi as $key => $dataCategories) {
            foreach($dataCategories[0] as $data){
                Article::create([
                    'title'         => $data["title"],
                    'banner'        => $data["urlToImage"],
                    'description'   => $data["description"],
                    'content'       => $data["content"],
                    'source'        => $data["source"]["name"],
                    'url'           => $data["url"],
                    'category'      => $key,
                    'author'        => $data["author"],
                    'publishedAt'   => (new \DateTime($data["publishedAt"]))->format("Y-m-d H:i:s")
                ]);
            }
        }

        $dataNYTimesApi = array();
        $dataNYTimesApi["election"][] = (new NYTimesSource())->getData("election")["response"]["docs"];
        $dataNYTimesApi["soccer"][] = (new NYTimesSource())->getData("soccer")["response"]["docs"];
        // 20 articles

        foreach($dataNYTimesApi as $key => $dataCategories) {
            foreach($dataCategories[0] as $data){
                $author = "";
                if(isset($data["byline"]["person"][0])){
                    $author = $data["byline"]["person"][0]["firstname"]." ".$data["byline"]["person"][0]["middlename"]." ".$data["byline"]["person"][0]["lastname"];
                }
                Article::create([
                    'title'         => $data["headline"]["main"],
                    'banner'        => isset($data["multimedia"][0]) ? "https://nytimes.com/".$data["multimedia"][0]["url"] : "",
                    'description'   => $data["snippet"],
                    'content'       => $data["lead_paragraph"],
                    'source'        => $data["source"],
                    'url'           => $data["web_url"],
                    'category'      => $key,
                    'author'        => $author,
                    'publishedAt'   => (new \DateTime($data["pub_date"]))->format("Y-m-d H:i:s")
                ]);
            }
        }


        $dataTheGuardianApi = array();
        $dataTheGuardianApi["nba"][] = (new TheGuardianApiSource())->getData("nba")["response"]["results"];
        $dataTheGuardianApi["brazil"][] = (new TheGuardianApiSource())->getData("brazil")["response"]["results"];
        $dataTheGuardianApi["covid"][] = (new TheGuardianApiSource())->getData("covid")["response"]["results"];
        // 30 articles

        foreach($dataTheGuardianApi as $key => $dataCategories) {
            foreach($dataCategories[0] as $data){
                Article::create([
                    'title'         => $data["webTitle"],
                    'banner'        => "",
                    'description'   => "",
                    'content'       => $data["webTitle"],
                    'source'        => "The Guardian",
                    'url'           => $data["webUrl"],
                    'category'      => $key,
                    'author'        => "The Guardian",
                    'publishedAt'   => (new \DateTime($data["webPublicationDate"]))->format("Y-m-d H:i:s")
                ]);
            }
        }

    }
}
