<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    public function index(int $id): Article
    {
        try {
            return Article::find($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
