<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function top()
    {
        $articles = Article::latest('id', 'updated_at')->take(3)->get();

        return ArticleResource::collection($articles);
    }

    public function all(Request $request)
    {
        $articles = Article::query()->latest('id', 'updated_at');

        $articles = $request->pagination ?
            $articles->paginate(10) :
            $articles->get()
        ;

        # dd($articles);

        return ArticleResource::collection($articles);
    }

    public function get(Article $article)
    {
        return new ArticleResource($article);
    }
}
