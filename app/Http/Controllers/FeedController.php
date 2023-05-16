<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class FeedController extends Controller
{
    public function index(Request $request): Article
    {
        try {
            $articlesQuery = Article::query();

            if($request->get('q') !== null) {
                $articlesQuery->where('title', 'like', '%'.$request->get('q').'%');
            }

            if($request->get('category') !== null) {
                $articlesQuery->where('category', '=', $request->get('category'));
            }

            if($request->get('source') !== null) {
                $articlesQuery->where('source', '=', $request->get('source'));
            }

            if($request->get('publishedAt') !== null) {
                $articlesQuery->where('publishedAt', '=', $request->get('publishedAt'));
            }

            // user preferences

            return $articlesQuery
                ->orderBy('publishedAt', 'desc')
                ->paginate(25);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
