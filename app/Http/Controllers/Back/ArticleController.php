<?php

namespace App\Http\Controllers\Back;

use App\DataTables\ArticleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\ArticleRequest;
use App\Models\Article;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ArticleDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(ArticleDataTable $dataTable)
    {
        return $dataTable->render('back.shared.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $article = null;

        $clubs = Club::all()->pluck('libelle', 'id');

        return view('back.article.form', compact('article', 'clubs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ArticleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $inputs = $this->getInputs($request);

        Article::create($inputs);

        return back()->with('ok', 'The post has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $clubs = Club::all()->pluck('libelle', 'id');
        return view('back.article.form', compact('article', 'clubs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ArticleRequest $request
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $inputs = $this->getInputs($request);

        if($request->has('image')) {
            $this->deleteImages($article);
        }

        $article->update($inputs);

        return back()->with('ok', 'The post has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return response()->json();
    }


    ### Manage upload image

    protected function getInputs($request)
    {
        $inputs = $request->except(['image']);

        # $inputs['active'] = $request->has('active');

        if($request->image) {
            $inputs['image'] = $this->saveImages($request);
        }

        # dd($inputs);

        return $inputs;
    }

    protected function saveImages($request)
    {
        # dd($request->file('image'));

        $image = $request->file('image');
        $name  = time() . '.' . $image->extension();
        $img   = Image::make($image->path());

        # $img->resize(width, height);

        $img->widen(800)->encode()->save(public_path('/storage/images/') . $name);
        $img->widen(400)->encode()->save(public_path('/storage/images/thumbs/') . $name);

        return $name;
    }

    protected function deleteImages($annonce)
    {
        File::delete([
            public_path('/storage/images/') . $annonce->image,
            public_path('/storage/images/thumbs/') . $annonce->image,
        ]);
    }
}
