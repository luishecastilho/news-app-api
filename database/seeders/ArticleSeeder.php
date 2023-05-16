<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Article;

use App\Http\Controllers\Sources\{
    NewsApiSource,
    NYTimesApiSource,
    //,
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
        $dataNYTimesApi["election"][] = (new NYTimesApiSource())->getData("election")["response"]["docs"];
        $dataNYTimesApi["soccer"][] = (new NYTimesApiSource())->getData("soccer")["response"]["docs"];

        foreach($dataNYTimesApi as $key => $dataCategories) {
            foreach($dataCategories[0] as $data){
                $autho = "";
                if(isset($data["byline"]["person"][0])){
                    $author = $data["byline"]["person"][0]["firstname"]." ".$data["byline"]["person"][0]["middlename"]." ".$data["byline"]["person"][0]["lastname"];
                }
                Article::create([
                    'title'         => $data["headline"]["main"],
                    'banner'        => "https://nytimes.com/".$data["multimedia"][0]["url"],
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

    }
}
