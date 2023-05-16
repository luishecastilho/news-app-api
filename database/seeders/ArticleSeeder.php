<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Article;

use App\Http\Controllers\Sources\{
    NewsApiSource,
    //,
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
    }
}
