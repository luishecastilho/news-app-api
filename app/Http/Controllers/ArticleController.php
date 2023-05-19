<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    public function index(int $id)
    {
        try {
            $article = Article::find($id);

            if($article){
                return response()->json(["data" => $article, "message" => "Article data found."], 200);
            }

            return response()->json(["data" => [], "message" => "Article not found."], 400);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }
}
