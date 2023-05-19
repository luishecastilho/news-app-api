<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\UserPreference;
use Carbon\Carbon;
use Auth;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        try {
            $articlesQuery = Article::query();

            $userPreference = UserPreference::where('user_id', Auth::id())->first();

            if($userPreference) {
                if($userPreference["sources"] !== null && $userPreference["sources"] !== "") {
                    $articlesQuery->whereIn("source", explode(",", $userPreference["sources"]));
                }
                if($userPreference["categories"] !== null && $userPreference["categories"] !== "") {
                    $articlesQuery->whereIn("category", explode(",", $userPreference["categories"]));
                }
                if($userPreference["authors"] !== null && $userPreference["authors"] !== "") {
                    $articlesQuery->whereIn("author", explode(",", $userPreference["authors"]));
                }
            }

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

            $articles = $articlesQuery
                            ->orderBy('publishedAt', 'desc')
                            ->paginate(15);

            return response()->json(["data" => ["articles" => $articles], "message" => "List of articles."], 200);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }
    public function filterData()
    {
        try {
            $articlesQuery = Article::query();

            $userPreference = UserPreference::where('user_id', Auth::id())->first();

            if($userPreference) {
                if($userPreference["sources"] !== null && $userPreference["sources"] !== "") {
                    $articlesQuery->whereIn("source", explode(",", $userPreference["sources"]));
                }
                if($userPreference["categories"] !== null && $userPreference["categories"] !== "") {
                    $articlesQuery->whereIn("category", explode(",", $userPreference["categories"]));
                }
                if($userPreference["authors"] !== null && $userPreference["authors"] !== "") {
                    $articlesQuery->whereIn("author", explode(",", $userPreference["authors"]));
                }
            }

            $articles = $articlesQuery->get();

            foreach($articles as $article) {
                $sources[] = $article["source"];
                $categories[] = $article["category"];
            }

            return response()->json(["data" => ["sources" => array_values(array_unique($sources)), "categories" => array_values(array_unique($categories))], "message" => "List of data for filtering."], 200);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }
}
