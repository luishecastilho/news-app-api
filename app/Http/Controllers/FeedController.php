<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Carbon\Carbon;
use Auth;

class FeedController extends Controller
{
    public function index(Request $request)
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
                $articlesQuery->whereDate('publishedAt', '=', Carbon::parse($request->get('publishedAt'))->format("Y-m-d"));
            }

            // user preferences
            // user preferences
            // user preferences
            // user preferences
            // user preferences

            $articles = $articlesQuery
                            ->orderBy('publishedAt', 'desc')
                            ->paginate(25);

            return response()->json(["data" => ["articles" => $articles], "message" => "List of articles."], 200);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }
}
