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

    public function all()
    {
        return ArticleResource::collection(Article::all());
    }

    public function get(Article $article)
    {
        return new ArticleResource($article);
    }
}
